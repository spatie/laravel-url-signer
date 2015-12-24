<?php

namespace Spatie\UrlSigner\Laravel;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Spatie\UrlSigner\Laravel\Middleware\ValidateSignature;
use Spatie\UrlSigner\UrlSigner as UrlSignerContract;

class UrlSignerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-url-signer.php' =>
                $this->app->configPath().'/'.'laravel-url-signer.php',
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/laravel-url-signer.php', 'laravel-url-signer');

        $config = config('laravel-url-signer');

        $config['signatureKey'] = 'mysecretkey';

        $this->app->singleton(UrlSignerContract::class, function () use ($config) {
            return new UrlSigner(
                $config['signatureKey'],
                $config['parameters']['expires'],
                $config['parameters']['signature']
            );
        });

        $this->app->alias(UrlSignerContract::class, 'url-signer');

        $this->app[Router::class]->middleware('signedurl', ValidateSignature::class);
    }
}
