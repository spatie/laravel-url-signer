<?php

namespace Spatie\UrlSigner\Laravel\Middleware;

use Closure;

class ValidateSignature
{
    public function handle($request, Closure $next)
    {
        $urlHasValidSignature = app('url-signer')->validate($request->fullUrl());

        if (! $urlHasValidSignature) {
            $this->handleUnsignedUrl($request);
        }

        return $next($request);
    }

    protected function handleUnsignedUrl($request)
    {
        abort(403);
    }
}
