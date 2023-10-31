<?php

namespace CarmineRumma\YousignLaravel;

use CarmineRumma\YousignLaravel\Request\CreateSignatureRequest;
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
      'production' => "https://api.yousign.com",
      'staging' => "https://staging-api.yousign.com",
    ];

    const SUPPORTED_LOCALES = ['en', 'fr', 'de', 'it', 'nl', 'es', 'pl'];

    protected $baseUrl;
    protected $baseUrlWithoutSlash;
    protected $apiKey;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \JsonMapper
     */
    protected $mapper;

    protected $locale = 'en';

    protected $_procedure = array(
        'name' => '',
        'description' => '',
        'start' => false,
        'expiresAt' => null,
        'template' => false,
        'ordered' => false,
        'metadata' => [],
        'config' => array(),
        'archive' => false
    );

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
        $this->setBearerToken(env('YOUSIGN_KEY'));
        $this->apiBaseUrl = env('YOUSIGN_API_URL');
        $this->baseUrlWithoutSlash = substr(env('YOUSIGN_API_URL'), 0, -1);

        $this->client = new Client(['expect' => false]);
        $this->mapper = new \JsonMapper();
        $this->mapper->bExceptionOnMissingData = false;
        $this->mapper->bExceptionOnUndefinedProperty = false;
        $this->mapper->bStrictNullTypes = false;
    }

    /**
     * Set API KEY from Yousign
     * @param $apiKey
     */
    private function setBearerToken($apiKey) {
        $this->apiKey = $apiKey;
    }

    /**
     * Set LOCALE
     * @param $apiKey
     */
    public function setLocale($str) {
      $this->locale = $str;
      return $this;
    }

    /**
     * Set procedure key/value
     *
     * @param $apiKey
     */

    public function setProcedureKeyValue($key, $value) {
        $this->_procedure[$key] = $value;
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
     * @return mixed
     */
    public function getBearerToken() {
        return $this->apiKey;
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
    public function doRequest($path, $method, $params = [], $removeSlash = false, $mapToClass = null, $contentType = 'application/json', $multipart = false)
    {
        if ($removeSlash) {
            $baseUrl = $this->baseUrlWithoutSlash;
        } else {
            $baseUrl = $this->apiBaseUrl;
        }

        try {

          $headers = [
            'Authorization' => 'Bearer ' . $this->getBearerToken(),
            'Accept' => 'application/json',
            'content-type' => $contentType, //'application/json'
          ];
          $options = [
            'body' => json_encode($params),
            'headers' => $headers
          ];

          if ($multipart) {
            unset($headers['content-type']);
            $options = array_merge($params, ['headers' => $headers]);
           // dd($options);
          }
         // $options['debug'] = true;
          if ($mapToClass == AddSignerToSignatureRequestRawResponse::class) {

            //dd($params);
          }
          $response = $this->client->request($method, $baseUrl . '/' . $path, $options);

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
     * @parms
     * @return mixed
     */
    public function createProcedure() {
        $method = 'POST';
        $path = 'procedures';

        $this->_procedure['config']['webhook'] = $this->_webhook;
        return $this->doRequest($path, $method, $this->_procedure);
    }

    /**
     * createSignatureRequest
     * @return CreateSignatureRequestRawResponse
     */
    public function createSignatureRequest() {
      $method = 'POST';
      $path = 'signature_requests';

      //$this->_procedure['config']['webhook'] = $this->_webhook;
      $this->signatureRequest = $this->doRequest($path, $method, $this->_signature, false,CreateSignatureRequestRawResponse::class);
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
      ], true, AddDocumentToSignatureRequestRawResponse::class, 'application/json', true);

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
        return $this->doRequest($path, $method, $params, true, AddSignerToSignatureRequestRawResponse::class);
    }

    /**
     * @params fileId string
     * @params memberId string
     * @params position string positionning signature see https://placeit.yousign.fr/
     * @params reason string see https://dev.yousign.com/#ba613ed7-08fa-45ea-9b5f-5e850aa367dc
     * @params procedureId string
     * @params page int num page where to put the signature
     * @params type int (2 types of fields: signature (default value) or text which will be used for text fields.)
     * @params contentRequired bool see https://dev.yousign.com/#3e7c6772-e92a-4b3d-98d0-84c22a64f3d7
     * @params content string|null see https://dev.yousign.com/#3e7c6772-e92a-4b3d-98d0-84c22a64f3d7
     * @params mention1 string
     * @params mention2 string
     *
     * @return mixed
     */

    public function addFileObject($fileId, $memberId, $position, $reason, $page, $type = 'signature', $contentRequired = true, $content = null, $mention = null, $mention2 = null) {
        $method = 'POST';
        $path = 'file_objects';

        $parameter = array(
            "file" => $fileId,
            "member" => $memberId,
            "position" => $position,
            "page" => $page,
            "mention" => $mention,
            "mention2" => $mention2,
            "reason" => $reason,
            "content" => $content,
            "contentRequired" => $contentRequired,
        );

        return $this->doRequest($path, $method, $parameter);
    }

    /**
     *  used for start the procedure and get signature list
     *
     */

    public function launchProcedure($procedureId) {
        $method = 'PUT';

        $parameter = array(
            'start' => true
        );

        // remove slash because the id is /procedure/id-XXXXXXXX
        return $this->doRequest($procedureId, $method, $parameter, true);
    }

    /**
     *  Consumption
     */

    public function consumption() {
        $method = 'PUT';
        $path = 'consumptions/metrics';

        return $this->doRequest($path, $method);
    }

    /**
     *  getFileSigned
     */

    public function fileSigned($fileId, $binaryMode = true) {
        $method = 'GET';

        if ($binaryMode) {
            $path =  $fileId . "/download?alt=media";
        } else{
            $path =  $fileId . "/download";
        }

        return $this->doRequest($path, $method, [], true, true);
    }

}
