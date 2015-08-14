<?php

namespace Spatie\SignedUrl\Laravel;

use Illuminate\Support\ServiceProvider;
use Spatie\SignedUrl\SignedUrl;

class SignedUrlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-signedurl.php' =>
                $this->app->configPath().'/'.'laravel-signedurl.php',
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../resources/config/laravel-signedurl.php', 'laravel-signedurl');

        $config = config('laravel-signedurl');

        $this->app->bindShared(SignedUrl::class, function () use ($config) {
            return new SignedUrl(
                $config['signatureKey'],
                $config['parameters']['expires'],
                $config['parameters']['signature']
            );
        });

        $this->app->alias(SignedUrl::class, 'signedurl');
    }
}
