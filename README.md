# Create secured URLs with a limited lifetime in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)
[![Build Status](https://img.shields.io/travis/spatie/laravel-url-signer.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-url-signer)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-url-signer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-url-signer)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/24f14ee1-92d5-4dfc-a91f-f789fd61f14b/mini.png)](https://insight.sensiolabs.com/projects/24f14ee1-92d5-4dfc-a91f-f789fd61f14b)
[![StyleCI](https://styleci.io/repos/40713346/shield?branch=master)](https://styleci.io/repos/40713346)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)

This package can create URLs with a limited lifetime. This is done by adding an expiration date and a signature to the URL.

This is how you can create signed URL that's valid for 30 days:

```php
UrlSigner::sign('https://myapp.com/protected-route', 30);
```

The output will look like this:

```
https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx
```

The URL can be validated with the `validate`-function.

```php
UrlSigner::validate('https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx');
```

The package also provides [a middleware to protect routes](https://github.com/spatie/laravel-url-signer#protecting-routes-with-middleware).

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment you are required to send us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Installation

As you would have guessed the package can be installed via Composer:

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
    'default_expiration_time_in_days' => 1,

    /*
     * These strings are used a parameter names in a signed url.
     */
    'parameters' => [
        'expires' => 'expires',
        'signature' => 'signature',
    ],

];
```
##Usage

###Signing URLs
URL's can be signed with the `sign`-method:
```php
UrlSigner::sign('https://myapp.com/protected-route');
```
By default the lifetime of an URL is one day. This value can be change in the config-file.
If you want a custom life time, you can specify the number of days the URL should be valid:

```php
//the generated URL will be valid for 5 days.
UrlSigner::sign('https://myapp.com/protected-route', 5);
```

For fine grained control, you may also pass a `DateTime` instance as the second parameter. The url
will be valid up to that moment. This example uses Carbon for convenience:
```php
//This URL will be valid up until 2 hours from the moment it was generated.
UrlSigner::sign('https://myapp.com/protected-route', Carbon\Carbon::now()->addHours(2); );
```

###Validating URLs
To validate a signed URL, simply call the `validate()`-method. This return a boolean.
```php
UrlSigner::validate('https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx');
```

###Protecting routes with middleware
The package also provides a middleware to protect routes:

```php
Route::get('protected-route', ['middleware' => 'signedurl', function () {
    return 'Hello secret world!';
}]);
```
Your app will abort with a 403 status code if the route is called without a valid signature.


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
```

##Usage outside Laravel
If you're working on a non-Laraval project, you can use the [framework agnostic version](https://github.com/spatie/url-signer).

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
