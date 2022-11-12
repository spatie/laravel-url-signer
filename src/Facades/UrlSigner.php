<?php

namespace Spatie\UrlSigner\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class UrlSigner extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'url-signer';
    }
}
