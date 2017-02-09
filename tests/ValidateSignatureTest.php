<?php

namespace Spatie\UrlSigner\Laravel\Test;

use DateTime;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateSignatureTest extends TestCase
{
    /** @test */
    public function it_registered_an_md5_url_signer_in_the_container()
    {
        $instance = $this->app['url-signer'];

        $this->assertInstanceOf(\Spatie\UrlSigner\UrlSigner::class, $instance);
        $this->assertInstanceOf(\Spatie\UrlSigner\MD5UrlSigner::class, $instance);
        $this->assertInstanceOf(\Spatie\UrlSigner\Laravel\URLSigner::class, $instance);
    }

    /** @test */
    public function it_rejects_an_unsigned_url()
    {
        $url = "{$this->hostName}/protected-route";

        $this->assert403Response($url);
    }

    /** @test */
    public function it_accepts_a_signed_url()
    {
        $url = $this->app['url-signer']->sign("{$this->hostName}/protected-route", 1);

        $this->assert200Response($url);
    }

    /** @test */
    public function it_rejects_a_forged_url()
    {
        $url = "{$this->hostName}/protected-route?expires=123&signature=456";

        $this->assert403Response($url);
    }

    /**
     * Assert wether a GET request to a URL returns a 200 response.
     *
     * @param string $url
     */
    protected function assert200Response($url)
    {
        $this->assertEquals(200, $this->call('GET', $url)->getStatusCode());
    }

    /**
     * Assert wether a GET request to a URL returns a 403 response.
     *
     * @param string $url
     */
    protected function assert403Response($url)
    {
        // Laravel 5.3 doesn't seem to throw an HttpException in this context,
        // so we're going to do a check in the try and in the catch
        // (only one of them will get called)
        try {
            $response = $this->call('GET', $url);
            $this->assertEquals(403, $response->getStatusCode());

            return;
        } catch (HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());

            return;
        }

        $this->fail('Response was ok');
    }
}
