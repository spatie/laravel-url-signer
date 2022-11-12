<?php

namespace Spatie\UrlSigner\Laravel;

use DateTime;
use Spatie\UrlSigner\MD5UrlSigner;

class UrlSigner extends MD5UrlSigner
{
    public function sign(
        string $url,
        int|DateTime $expiration = null,
        string $signatureKey = null,
    ): string {
        $expiration ??= config('url-signer.default_expiration_time_in_seconds');

        return parent::sign($url, $expiration, $signatureKey);
    }
}
