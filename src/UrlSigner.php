<?php

namespace Spatie\UrlSigner\Laravel;

use DateTime;
use Spatie\UrlSigner\MD5UrlSigner;

class UrlSigner extends MD5UrlSigner
{
    /**
     * Get a secure URL to a controller action.
     *
     * @param  string  $url
     * @param  \DateTime|int|null  $expiration Defaults to the config value
     * @return string
     */
    public function sign(
        string $url,
        int|DateTime $expiration,
        string $signatureKey = null,
    ): string {
        $expiration = $expiration ?? config('url-signer.default_expiration_time_in_seconds');

        return parent::sign($url, $expiration, $signatureKey);
    }
}
