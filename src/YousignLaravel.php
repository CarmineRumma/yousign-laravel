<?php

namespace CarmineRumma\YousignLaravel;

use CarmineRumma\YousignLaravel\Request\CreateSignatureRequest;
use CarmineRumma\YousignLaravel\Response\ActivateSignatureRequestRawResponse;
use CarmineRumma\YousignLaravel\Response\AddDocumentToSignatureRequestRawResponse;
use CarmineRumma\YousignLaravel\Response\AddSignerToSignatureRequestRawResponse;
use CarmineRumma\YousignLaravel\Response\CreateSignatureRequestRawResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use \Symfony\Component\HttpFoundation\File\File;

class YousignLaravel {

    /**
     * @const string
     */
    const BASE_URI = [
      'production'  => "https://api.yousign.app/v3/",
      'staging'     => "https://api-sandbox.yousign.app/v3/",
    ];

    /**
     * @const string
     */
    const SUPPORTED_LOCALES = ['en', 'fr', 'de', 'it', 'nl', 'es', 'pl'];

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiEnv;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \JsonMapper
     */
    protected $mapper;

    protected $locale = 'en';

    /**
     * @var CreateSignatureRequest
     */
    protected $_signature = array(
      'name' => '',
      'delivery_mode' => '',
      'ordered_signers' => false,
      'reminder_settings' => [
        'interval_in_days' => 1,
        'max_occurrences' => 5,
      ],
      'timezone' => 'Europe/Rome',
      'signers_allowed_to_decline' => false,
      'workspace_id' => null,
      'external_id' => null, // External ID will be added to webhooks & appended to redirect urls.
    );

    /**
     * @var CreateSignatureRequestRawResponse
     */
    private $signatureRequest = null;

    protected $_webhook = array(

    );

    // default content SMS
    protected $_operationModeSmsConfig = array(
        "content" => "DIGITAL SIGNATURE : {{code}} is your security code to confirm the signature of your documents."
    );

    public function __construct() {
        //$this->setBearerToken(env('YOUSIGN_KEY'));
        //$this->apiBaseUrl = env('YOUSIGN_API_URL');
        //$this->baseUrlWithoutSlash = substr(env('YOUSIGN_API_URL'), 0, -1);

        $this->setApiKey(config('yousign.api_key'));
        $this->setApiEnv(config('yousign.api_env'));

        $this->client = new Client([
          'expect' => false,
          'base_uri' => $this->getBaseURL(),
           'headers' => [
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
          ]
        ]);
        $this->mapper = new \JsonMapper();
        $this->mapper->bExceptionOnMissingData = false;
        $this->mapper->bExceptionOnUndefinedProperty = false;
        $this->mapper->bStrictNullTypes = false;
    }

    /**
     * @return string
     */
    protected function getBaseURL()
    {
      return self::BASE_URI[$this->apiEnv];
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
      return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    protected function setApiKey($apiKey)
    {
      $this->apiKey = $apiKey;
    }


    /**
     * @param string $apiEnv
     */
    public function setApiEnv($apiEnv)
    {
      $this->apiEnv = $apiEnv;
    }

    /**
     * @return string
     */
    protected function getApiEnv()
    {
      return $this->apiEnv;
    }

    /**
     * Set LOCALE
     * @param $apiKey
     */
    public function setLocale($str) {
      if (!in_array($str, self::SUPPORTED_LOCALES)) {
        throw new \Exception('Create a Signature Request before');
      }
      $this->locale = $str;
      return $this;
    }

    /**
     * Set Signature Request key/value
     * @param $key
     * @param $value
     * @return void
     */
    public function setSignatureRequestProperty($key, $value) {
      $this->_signature[$key] = $value;
    }

    /**
     * Set webhook value
     *
     * @param $apiKey
     */

    private function setWebhook($key, $value) {
        $this->_webhook[$key] = $value;
    }

    /**
     * Set add SMS Content
     *
     * @param $apiKey
     */

    public function addSmsContent($value) {
        $this->_operationModeSmsConfig['content'] = $value;
    }

    /**
     * get numPage from a pdf file
     */

    public function getNumPagesInPDF($file)
    {
        $file_headers = @get_headers($file);
        if ($file_headers[0] == 'HTTP/1.1 404 Not Found') return null;
        if (!$fp = @fopen($file, "r")) return null;
        $max = 0;
        while (!feof($fp)) {
            $line = fgets($fp, 255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                preg_match('/[0-9]+/', $matches[0], $matches2);
                if ($max < $matches2[0]) $max = $matches2[0];
            }
        }
        fclose($fp);
        return (int)$max;
    }

    /**
     * Set add Webhook
     *
     * @param $apiKey
     */

    public function addWebhook($type, $url, $method, $headers = []) {
        $webhook = array(
            array(
                "url" => $url,
                "method" => $method,
                "headers" => $headers
            )
        );
        $this->setWebhook($type, $webhook);
    }

    /**
     * @param $path
     * @param $method
     * @param $params
     * @param $removeSlash
     * @param $mapToClass
     * @return mixed|object|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function doRequest($path, $method, $params = [], $mapToClass = null, $multipart = false)
    {
        try {

          $options = [
            'body' => json_encode($params)
          ];

          if ($multipart) {
            $options = $params;
          }
          $response = $this->client->request($method, $path, $options);
          // dd($response);
          $contents = $response->getBody()->getContents();
          $contentsObj = json_decode($contents);

          if ($mapToClass) {
            return $this->mapper->map($contentsObj, $mapToClass);
          }
          return $contentsObj;

        } catch (ClientException $e) {
            print ($e->getMessage()); die;
            abort($response->status(), $response->body(), ['Content-Type: application/json']);
        }

    }

    /**
     * createSignatureRequest
     * @return CreateSignatureRequestRawResponse
     */
    public function createSignatureRequest() {
      $method = 'POST';
      $path = 'signature_requests';

      //$this->_procedure['config']['webhook'] = $this->_webhook;
      $this->signatureRequest = $this->doRequest($path, $method, $this->_signature, CreateSignatureRequestRawResponse::class);
      return $this;
    }

    /**
     * addDocumentToSignatureRequest
     * @return CreateSignatureRequestRawResponse
     */
    public function addDocumentToSignatureRequest($doc) {
      if (is_null($this->signatureRequest)) {
        throw new \Exception('Create a Signature Request before');
      }
      $method = 'POST';
      $path = 'signature_requests/' . $this->signatureRequest->id . '/documents';

      $file = new File(storage_path('app/public/') . $doc->attachment);
      /*
      $data = file_get_contents(
        storage_path('app/public/') . $doc->attachment
      );
      $b64Doc = base64_encode($data);
      */

      //$this->_procedure['config']['webhook'] = $this->_webhook;
       return $this->doRequest($path, $method, [
          'multipart' => [
            [
              'name' => 'nature',
              'contents' => 'signable_document' //'attachment'
            ],
            [
              'name'     => 'file',
              'contents' => Psr7\Utils::tryFopen($file->getPathname(), 'r')
            ]
          ]
      ], AddDocumentToSignatureRequestRawResponse::class, true);

    }

    /**
     * @params firstname string
     * @params lastname string
     * @params email string
     * @params phone string
     * @params documentId string
     *
     * @return AddSignerToSignatureRequestRawResponse
     */
    public function addSigner($firstname, $lastname, $email, $phone, $documentId) {
      if (is_null($this->signatureRequest)) {
        throw new \Exception('Create a Signature Request before');
      }
      $method = 'POST';
        $path = 'signature_requests/' . $this->signatureRequest->id . '/signers';

        $info = array(
            "first_name" => $firstname,
            "last_name" => $lastname,
            "email" => $email,
            "phone_number" => $phone,
            "locale" => $this->locale
        );
        $fields = array(
          array(
            'document_id' => $documentId,
            'type' => 'signature',
            'page' => 1,
            'x' => 0,
            'y' => 0,
          ),
        );

        $params = [
          "info" => $info,
          "fields" => $fields,
          'signature_level' => 'electronic_signature',
          'signature_authentication_mode' => 'otp_email', //otp_sms
          'delivery_mode' => 'email'
        ];
        return $this->doRequest($path, $method, $params, AddSignerToSignatureRequestRawResponse::class);
    }

    /**
     * activateSignatureRequest
     * @return CreateSignatureRequestRawResponse
     */
    public function activateSignatureRequest() {
      if (is_null($this->signatureRequest)) {
        throw new \Exception('Create a Signature Request before');
      }
      $method = 'POST';
      $path = 'signature_requests/' . $this->signatureRequest->id . '/activate';

      //$this->_procedure['config']['webhook'] = $this->_webhook;
      return $this->doRequest($path, $method, [
      ], true, ActivateSignatureRequestRawResponse::class);

    }

}
