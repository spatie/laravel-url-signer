# Create secured URLs with a limited lifetime in Laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-url-signer.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-url-signer)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-url-signer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-url-signer)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)

Laravel 5.* implementation of [spatie/signed-url](https://github.com/spatie/signed-url). With this package you can generate URLs with an expiration date and signature to prevent unauthorized access, and protect the route via middleware.

Protect your routes with middleware: 

```php
Route::get('protected-route', ['middleware' => 'signedurl', function () {
    return 'Hello world!';
}]);

// Aborts with a 403 status code if the route is called without a valid signature
```

Generate a signed URL that's valid for 30 days: 

```php
UrlSigner::sign(url('protected-route'), 30);
```

Valid URL's look like this:

```
http://app.com/protected-route?expires=xxxxxx&signature=xxxxxx`
```

## Install

Via Composer:

```
$ composer require spatie/laravel-url-signer
```

To enable the package, register the serviceprovider, and optionally register the facade:

```php
// config/app.php

'providers' => [
    ...
    Spatie\UrlSigner\Laravel\UrlSignerServiceProvider::class,
];

'aliases' => [
    ...
    'UrlSigner' => Spatie\UrlSigner\Laravel\UrlSignerFacade::class,
];
```

## Configuration

The configuration file can be published via:

```
php artisan vendor:publish --provider="Spatie\UrlSigner\Laravel\UrlSignerServiceProvider"
```

There are several configurable options.

```
signatureKey
```

A random string used to encrypt the URL signatures. Default: `config('app.key')`.

```
default_expiration_time
```

The default expiration time of a URL in days. Default: 30.

```
parameters.expires & parameters.signature
```

Overwrite these if you want to use different query parameters. Defaults: `expires` & `signature`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne][link-author]
- [All Contributors][link-contributors]

## About Spatie

Spatie is a webdesign agency in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
