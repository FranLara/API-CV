<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

class ForceSecureProtocol
{
    /**
     * @return RedirectResponse|mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
