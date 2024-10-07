<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Lang;

class DomainLocale
{
    public function handle($request, Closure $next)
    {
        $domainParts = explode('.', $request->getHost());
        $extension = end($domainParts);

        match ($extension) {
            'es' => Lang::setLocale('es'),
            'com' => Lang::setLocale('en'),
            default => config('app.locale'),
        };

        return $next($request);
    }
}