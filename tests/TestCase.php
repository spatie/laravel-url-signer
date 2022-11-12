<?php

namespace Spatie\UrlSigner\Laravel\Tests;

use Illuminate\Support\Facades\Route;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\UrlSigner\Laravel\Middleware\ValidateSignature;
use Spatie\UrlSigner\Laravel\UrlSignerServiceProvider;

abstract class TestCase extends Orchestra
{
    protected string $hostName;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hostName = config('app.url');

        $this->registerDefaultRoute();
    }

    protected function getPackageProviders($app)
    {
        return [
            UrlSignerServiceProvider::class,
        ];
    }

    protected function registerDefaultRoute()
    {
        Route::aliasMiddleware('signed-url', ValidateSignature::class);

        Route::get('protected-route', fn () => 'Hello world!')->middleware('signed-url');
    }
}
