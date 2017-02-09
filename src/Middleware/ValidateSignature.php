<?php

namespace Spatie\UrlSigner\Laravel\Middleware;

use Closure;

class ValidateSignature
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $urlIsSigned = app('url-signer')->validate($request->fullUrl());

        if (! $urlIsSigned) {
            abort(403);
        }

        return $next($request);
    }
}
