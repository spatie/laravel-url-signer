<?php

namespace Spatie\SignedUrl\Laravel\Test;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\SignedUrl\Laravel\Middleware\ValidateSignature;
use Spatie\SignedUrl\Laravel\SignedUrlServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @var string
     */
    protected $hostName;

    public function setUp()
    {
        parent::setUp();

        $this->hostName = $this->app['config']->get('app.url');

        $this->registerDefaultRoute();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SignedUrlServiceProvider::class,
        ];
    }

    protected function registerDefaultRoute()
    {
        $this->app['router']->get('protected-route', ['middleware' => ValidateSignature::class, function () {
            return 'Hello world!';
        }]);
    }
}
