# YouSignLaravel

[![Latest Stable Version](https://poser.pugx.org/carminerumma/yousign-laravel/v/stable)](https://packagist.org/packages/carminerumma/yousign-laravel)
[![Total Downloads](https://poser.pugx.org/carminerumma/yousign-laravel/downloads)](https://packagist.org/packages/carminerumma/yousign-laravel)
[![Latest Unstable Version](https://poser.pugx.org/carminerumma/yousign-laravel/v/unstable)](https://packagist.org/packages/carminerumma/yousign-laravel)
[![License](https://poser.pugx.org/carminerumma/yousign-laravel/license)](https://packagist.org/packages/carminerumma/yousign-laravel)

It's a library for Laravel 7 and PHP7
Not tested on previous version.

Library to use YouSign API from doc (dev.yousign.com) with Laravel

Installation
------------

Install using composer

Now require the lib
```bash
composer require carminerumma/yousign-laravel
```

Add provider in config.app
```bash
'providers' => [
    CarmineRumma\YousignLaravel\YousignLaravelServiceProvider::class,
];

'aliases' => [
    'YousignLaravel' => CarmineRumma\YousignLaravel\Facade\YousignLaravel::class,
];
```

Complete informations inside your .env file (contact YouSign to get Credentials) and then
```bash
YOUSIGN_KEY=
YOUSIGN_API_URL=
```

Usage
------------

Create Procedure with webhooks , files and members
```php
use CarmineRumma\YousignLaravel\YousignLaravel;

class DocumentController extends Controller
{

  public function sign(Request $request) {
    $client = new YousignLaravel();

    // see all possibilities at https://dev.yousign.com/
    $client->setProcedureKeyValue('name', 'Yousign');
    $client->setProcedureKeyValue('description', 'Description procedure');
    // to set default expiration date to the signature
    $client->setProcedureKeyValue('expiresAt', '2022-04-24');

    // add webhooks 
    // you can add different headers
    $webhookUrl = env('API_URL') . 'yousign/';
    $client->addWebhook('member.finished', $webhookUrl . 'signature', 'GET', array(
        "X-Custom-Header" => $type . '-signature',
    ));
    $client->addWebhook('procedure.refused', $webhookUrl . 'refused', 'GET', array(
        "X-Custom-Header" => $type . '-signature',
    ));
    // procedure created but not ready for signature
    $procedure = $client->createProcedure();

    // Allows you to define the content of SMS. {{code}} will be used to define the security code managed by Yousign.
    // up to 150 characters
    $client->addSmsContent('DIGITAL SIGNATURE - {{code}} is your security code to sign your documents.');

    // add files to procedure
    $file = $client->addFile($namefile, $document->url, $procedure['id']);

    // add member to sign the documents
    $member = $client->addMember($user->firstname, $user->lastname, $user->email, $user->phone, $procedure['id']);

    // to determine the last page of your file
    $lastPageNumber = $this->getNumPagesInPDF($document->url);

    $reason = "Signed by " . $user->firstname . " " . $user->lastname . " (Yousign)";
    
    // to determine position see https://placeit.yousign.fr/
    $fileObject = $client->addFileObject($file['id'], $member['id'], $position, $reason, $lastPageNumber);

    // start the signature process
    $client->launchProcedure($procedure['id']);
  }
}
```

Find the complete integration in source file
