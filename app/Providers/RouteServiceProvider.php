<?php
declare(strict_types = 1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	public const HOME = '/';
	private const ROOT = 'App\Http\Controllers\\';

	/**
	 * Define your route model bindings, pattern filters, and other route configuration.
	 */
	public function boot(): void
	{
		resolve(UrlGenerator::class)->forceScheme('https');

		$this->routes(function () {
			Route::middleware('web')->namespace(self::ROOT . 'Web')
				->group(base_path('routes/web.php'));
		});

		$router = app('Dingo\Api\Routing\Router');

		$router->version('v1', function ($api) {
			require base_path('routes/api.php');
		});
	}
}
