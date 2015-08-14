<?php

namespace Spatie\SignedUrl\Laravel\Test;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ValidateSignatureTest extends TestCase
{
    /**
     * @test
     */
    public function it_rejects_an_unsigned_url()
    {
        $url = "{$this->hostName}/protected-route";

        $this->assert403Response($url);
    }

    /**
     * @test
     */
    public function it_accepts_a_signed_url()
    {
        $url = $this->app['signedurl']->sign("{$this->hostName}/protected-route", 1);

        $this->assert200Response($url);
    }

    /**
     * @test
     */
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
        try {
            $this->call('GET', $url);
        } catch (HttpException $e) {
            $this->assertEquals(403, $e->getStatusCode());
            return;
        }

        $this->fail();
    }
}
