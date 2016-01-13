<?php

namespace Spatie\UrlSigner\Laravel\Test;

use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\UrlSigner\Laravel\Http\Middleware\ValidateSignature;
use Spatie\UrlSigner\Laravel\UrlSignerServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @var string
     */
    protected $hostName;

    public function setUp()
    {
        $this->setApplicationKey();

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
            UrlSignerServiceProvider::class,
        ];
    }

    protected function setApplicationKey()
    {
        putenv('APP_KEY=mysecretkey');
    }

    protected function registerDefaultRoute()
    {
        $this->app['router']->get('protected-route', ['middleware' => 'signedurl', function () {
            return 'Hello world!';
        }]);
    }
}
