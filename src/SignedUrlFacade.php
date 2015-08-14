<?php

namespace Spatie\SignedUrl\Laravel;

use Illuminate\Support\Facades\Facade;

class SignedUrlFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'signedurl';
    }
}
