<?php

namespace Spatie\UrlSigner\Laravel\Tests;

use Spatie\UrlSigner\Laravel\Facades\UrlSigner;
use Spatie\UrlSigner\Md5UrlSigner;

beforeEach(function () {
    /** @var \Spatie\UrlSigner\Laravel\UrlSigner urlSigner */
    $this->urlSigner = app('url-signer');
});

it('registers an url signer', function () {
    expect($this->urlSigner)->toBeInstanceOf(Md5UrlSigner::class);
});

it('rejects an unsigned url', function () {
    $this
        ->get("{$this->hostName}/protected-route")
        ->assertForbidden();
});

it('accepts a signed url', function () {
    $url = $this->urlSigner->sign("{$this->hostName}/protected-route", 1);

    $this->get($url)->assertSuccessful();
});

it('rejects a forged url', function () {
    $this
        ->get("{$this->hostName}/protected-route?expires=123&signature=456")
        ->assertForbidden();
});

it('will not accept a signed url anymore after it expires', function () {
    $signedUrl = $this->urlSigner->sign('https://spatie.be', now()->addSeconds(2));

    sleep(1);

    expect($this->urlSigner->validate($signedUrl))->toBeTrue();

    sleep(2);

    expect($this->urlSigner->validate($signedUrl))->toBeFalse();
});

it('can sign and verify urls via the facade', function () {
    $signedUrl = UrlSigner::sign('https://spatie.be');

    expect(UrlSigner::validate($signedUrl))->toBeTrue();
});

it('can sign and verify using a custom secret', function () {
    $signedUrl = UrlSigner::sign('https://spatie.be', signatureKey: 'my-other-secret');

    expect(UrlSigner::validate($signedUrl, signatureKey: 'my-other-secret'))->toBeTrue();
    expect(UrlSigner::validate($signedUrl, signatureKey: 'wrong-secret'))->toBeFalse();
});
