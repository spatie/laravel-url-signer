<?php

namespace Spatie\UrlSigner\Laravel\Middleware;

use Closure;

class ValidateSignature
{
    public function handle($request, Closure $next)
    {
        $urlIsSigned = app('url-signer')->validate($request->fullUrl());

        if (! $urlIsSigned) {
            $this->handleUnsignedUrl($request);
        }

        return $next($request);
    }

    protected function handleUnsignedUrl($request)
    {
        abort(403);
    }
}
