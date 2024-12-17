<?php

declare(strict_types=1);

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends BaseMiddleware
{
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        if (empty($role)) {
            $this->checkForToken($request);

            return $next($request);
        }

        $authProvider = config('jwt.providers.auth');
        $provider = app('auth')->createUserProvider(config(sprintf('auth.guards.api.%s.provider', $role)));
        $guard = new JWTGuard(app('tymon.jwt'), $provider, app('request'), app('events'));
        $this->auth = new JWTAuth($this->auth->manager(), new $authProvider($guard), $this->auth->parser());
        $this->authenticate($request);

        return $next($request);
    }
}
