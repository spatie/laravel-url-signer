**THIS PACKAGE IS NOT MAINTAINED ANYMORE. 
SIGNING URLS IS NOW PART OF LARAVEL: https://laravel-news.com/signed-routes**

# Create secured URLs with a limited lifetime in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)
[![Build Status](https://img.shields.io/travis/spatie/laravel-url-signer.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-url-signer)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-url-signer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-url-signer)
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

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-url-signer.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-url-signer)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

As you would have guessed the package can be installed via Composer:

```
composer require spatie/laravel-url-signer
```

In Laravel 5.5 the service provider and facade will automatically get registered. In older versions of the framework, just add the serviceprovider, and optionally register the facade:

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

This is the content of the file:

```php
return [

    /*
    * This string is used the to generate a signature. You should
    * keep this value secret.
    */
    'signatureKey' => env('APP_KEY'),

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
## Usage

### Signing URLs
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
UrlSigner::sign('https://myapp.com/protected-route', Carbon\Carbon::now()->addHours(2) );
```

### Validating URLs
To validate a signed URL, simply call the `validate()`-method. This return a boolean.
```php
UrlSigner::validate('https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx');
```

### Protecting routes with middleware
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

## Usage outside Laravel

If you're working on a non-Laravel project, you can use the [framework agnostic version](https://github.com/spatie/url-signer).

## Similar libraries

If you need signed url's for CloudFront, consider [dreamonkey's package](https://github.com/dreamonkey/laravel-cloudfront-url-signer), which is based on this library.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
