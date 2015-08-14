# Create secured URLs with a limited lifetime in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-url-signer.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-url-signer)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-url-signer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-url-signer)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/24f14ee1-92d5-4dfc-a91f-f789fd61f14b/mini.png)](https://insight.sensiolabs.com/projects/24f14ee1-92d5-4dfc-a91f-f789fd61f14b)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)

This package can create URLs with a limited lifetime. This is done by adding an expiration date and a signature
to the URL.

This is how you can create signed URL that's valid for 30 days:

```php
UrlSigner::sign('https://myapp.com/protected-route', 30);
```

The output will look like thit:

```
https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx
```

The URL can be validated with the `validate`-function.
```php
UrlSigner::validate('https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx');
```

The package also provides a middleware to protect routes:

```php
Route::get('protected-route', ['middleware' => 'signedurl', function () {
    return 'Hello secret world!';
}]);

```
Your app will abort with a 403 status code if the route is called without a valid signature.


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

The configuration file can optionally be published via:

```
php artisan vendor:publish --provider="Spatie\UrlSigner\Laravel\UrlSignerServiceProvider"
```

This is the contents of the file:

```php
return [

    /*
    * This string is used the to generate a signature. You should
    * keep this value secret.
    */
    'signatureKey' => config('app.key'),

    /*
     * The default expiration time of a URL in days.
     */
    'default_expiration_time' => 1,

    /*
     * This strings are used a parameter names in a signed url.
     */
    'parameters' => [
        'expires' => 'expires',
        'signature' => 'signature',
    ],

];
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
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
