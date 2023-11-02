# YouSignLaravel

[![Latest Stable Version](https://poser.pugx.org/carminerumma/yousign-laravel/v/stable)](https://packagist.org/packages/carminerumma/yousign-laravel)
[![Total Downloads](https://poser.pugx.org/carminerumma/yousign-laravel/downloads)](https://packagist.org/packages/carminerumma/yousign-laravel)
[![Latest Unstable Version](https://poser.pugx.org/carminerumma/yousign-laravel/v/unstable)](https://packagist.org/packages/carminerumma/yousign-laravel)
[![License](https://poser.pugx.org/carminerumma/yousign-laravel/license)](https://packagist.org/packages/carminerumma/yousign-laravel)

It's a library for Laravel 7 and PHP7
Not tested on previous version.

Library to use YouSign API from doc (dev.yousign.com) with Laravel

## Installation

You can install the package via composer:

```bash
composer require carminerumma/yousign-laravel
```

The service provider will automatically register itself.

You must publish the config file with:
```bash
php artisan vendor:publish --provider="CarmineRumma\YousignLaravel\YousignServiceProvider" --tag="config"
```

This is the contents of the config file that will be published at `config/yousign.php`:

```php
return [
    'api_key' => env('YOUSIGN_API_KEY'),
    'api_env' => env('YOUSIGN_API_ENV', 'production'), // ['production', 'staging']
];
```

## Usage

### Users

Lists all users:
```php
use CarmineRumma\YousignLaravel\YousignLaravel;

$users = YousignLaravel::getUsers();
```

### Procedure

Send a file:
```php
use CarmineRumma\YousignLaravel\YousignLaravel;

$file = YousignLaravel::createFile([
    "name" => "devis.pdf",
    "content" => "JVBERi0xLjUKJb/3ov4KNiA...",
]);
```

Create a procedure:
_The creation of a procedure is fully dynamic, you can add multiple members and multiple files._
```php
use CarmineRumma\YousignLaravel\YousignLaravel;

$file = YousignLaravel::createFile([
    "name" => "devis.pdf",
    "content" => "JVBERi0xLjUKJb/3ov4KNiA...",
]);

$procedure = new YousignProcedure();
$procedure
    ->withName("My procedure")
    ->withDescription("The description of my procedure")
    ->addMember([
        'firstname' => "Alexis",
        'lastname' => "Riot",
        'email' => "contact@alexisriot.fr",
        'phone' => "+33 600000000",
    ], [$file])
    ->send();
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.


## Creator

- [@CarmineRumma](https://github.com/CarmineRumma)
