<?php

declare(strict_types=1);

namespace App\Http\Middleware\Api;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use PHPOpenSourceSaver\JWTAuth\Providers\Auth\Illuminate;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class Authenticate extends BaseMiddleware
{
	public function handle(Request $request, Closure $next, string $role = null): Response
    {
    	if(empty($role)){
    		$this->checkForToken($request);

    		return $next($request);
    	}

    	$guard = new JWTGuard(app('tymon.jwt'),app('auth')->createUserProvider('admins'),app('request'),app('events'));
    	$auth = new Illuminate($guard);
		$this->auth = new JWTAuth($this->auth->manager(), $auth, $this->auth->parser());
		$this->authenticate($request);

        return $next($request);
    }
}
