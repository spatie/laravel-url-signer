<?php

namespace Spatie\UrlSigner\Laravel;

use Illuminate\Contracts\Foundation\Application;
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
        $this->setupConfig($this->app);
    }

    /**
     * Setup the config.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function setupConfig(Application $app)
    {
        $source = realpath(__DIR__.'/../config/laravel-url-signer.php');
        $this->publishes([$source => config_path('laravel-url-signer.php')]);
        $this->mergeConfigFrom($source, 'laravel-url-signer');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-url-signer.php', 'laravel-url-signer');

        $config = config('laravel-url-signer');

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
