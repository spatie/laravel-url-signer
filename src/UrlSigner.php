<?php

namespace Spatie\UrlSigner\Laravel;

use Spatie\UrlSigner\MD5UrlSigner;

class UrlSigner extends MD5UrlSigner
{
    /**
     * Get a secure URL to a controller action.
     *
     * @param string             $url
     * @param \DateTime|int|null $expiration Defaults to the config value
     *
     * @return string
     */
    public function sign($url, $expiration = null): string
    {
        $expiration = $expiration ?? config('url-signer.default_expiration_time_in_days');

        return parent::sign($url, $expiration);
    }
}
