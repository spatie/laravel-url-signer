<?php

namespace Spatie\UrlSigner\Laravel;

use DateTime;
use Spatie\UrlSigner\Md5UrlSigner;

class UrlSigner extends Md5UrlSigner
{
    public function sign(
        string $url,
        int|DateTime|null $expiration = null,
        ?string $signatureKey = null,
    ): string {
        $expiration ??= config('url-signer.default_expiration_time_in_seconds');

        return parent::sign($url, $expiration, $signatureKey);
    }
}
