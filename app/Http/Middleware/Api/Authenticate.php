<?php
declare(strict_types = 1);

namespace App\Http\Middleware\Api;

use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTGuard;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class Authenticate extends BaseMiddleware
{

	public function handle(Request $request, Closure $next, string $role = null): Response
	{
		if (empty($role)) {
			$this->checkForToken($request);

			return $next($request);
		}

		$authProvider = config('jwt.providers.auth');
		$provider = sprintf('auth.guards.api.%s.provider', $role);
		$guard = new JWTGuard(app('tymon.jwt'), app('auth')->createUserProvider(config($provider)), app('request'), app('events'));
		$this->auth = new JWTAuth($this->auth->manager(), new $authProvider($guard), $this->auth->parser());
		$this->authenticate($request);

		return $next($request);
	}
}
