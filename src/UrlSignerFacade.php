<?php

namespace Spatie\UrlSigner\Laravel;

use Illuminate\Support\Facades\Facade;

class UrlSignerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'url-signer';
    }
}
