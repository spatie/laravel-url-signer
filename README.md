# Create signed URLs with a limited lifetime in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)
[![Build Status](https://img.shields.io/travis/spatie/laravel-url-signer.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-url-signer)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-url-signer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-url-signer)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-url-signer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-url-signer)

This package can create URLs with a limited lifetime. This is done by adding an expiration date and a signature to the URL.

The difference with [Laravel's native route signing](https://laravel.com/docs/master/urls#signed-urls) is that using this package:

- the secret used is not tied to the app key
- allows you to easily sign any URL (and not only a route belonging to your app), this makes it easy to use signed URLs between different apps.

This is how you can create signed URL that's valid for 30 days:

```php
use Spatie\UrlSigner\Laravel\Facades\UrlSigner;

UrlSigner::sign('https://myapp.com/protected-route', now()->addDays(30);
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

As you would have guessed the package can be installed via composer:

```bash
composer require spatie/laravel-url-signer
```

You must set an environment variable called `URL_SIGNER_SIGNATURE_KEY` and set it to a long secret value. This value will be used to sign and validate signed URLs.

```
# in your .env file

URL_SIGNER_SIGNATURE_KEY=some_random_value
```

The configuration file can optionally be published via:

```bash
php artisan vendor:publish --tag="url-signer-config"
```

This is the content of the file:

```php
return [
    /*
    * This string is used the to generate a signature. You should
    * keep this value secret.
    */
    'signature_key' => env('URL_SIGNER_SIGNATURE_KEY'),

    /*
     * The default expiration time of a URL in seconds.
     */
    'default_expiration_time_in_seconds' => 60 * 60 * 24,

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

URL's can be signed with the `sign`-method:

```php
use Spatie\UrlSigner\Laravel\Facades\UrlSigner;

UrlSigner::sign('https://myapp.com/protected-route');
```

By default, the lifetime of an URL is one day. This value can be change in the config file.
If you want a custom lifetime, you can specify the number of days the URL should be valid:

```php
use Spatie\UrlSigner\Laravel\Facades\UrlSigner;

// the generated URL will be valid for 5 minutes.
UrlSigner::sign('https://myapp.com/protected-route', now()->addMinutes(5));

// alternatively you could also pass the amount of seconds
UrlSigner::sign('https://myapp.com/protected-route', 60 * 5);
```

### Validating URLs

To validate a signed URL, simply call the `validate()`-method. This method returns a boolean.

```php
use Spatie\UrlSigner\Laravel\Facades\UrlSigner;

UrlSigner::validate('https://app.com/protected-route?expires=xxxxxx&signature=xxxxxx');
```

### Protecting routes with middleware

The package provides a middleware to protect routes.

To use it you must first register the `Spatie\UrlSigner\Laravel\Middleware\ValidateSignature` as route middleware in your HTTP kernel.

```php
// in app/Http/Kernel.php

protected $routeMiddleware = [
    // ...
    'signed-url' => \Spatie\UrlSigner\Laravel\Middleware\ValidateSignature::class,
];
```

Next, you can apply it on any route you want.

```php
Route::get('protected-route', fn () => 'Hello secret world!')
    ->middleware('signed-url');
```

Your app will abort with a 403 status code if the route is called without a valid signature.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

You can run the test using this command:

```bash
composer test
```

## Usage outside Laravel

If you're working on a non-Laravel project, you can use the [framework agnostic version](https://github.com/spatie/url-signer).

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
