<?php

declare(strict_types=1);

namespace App\Providers;

use Dingo\Api\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const string HOME = '/';
    private const string ROOT = 'App\Http\Controllers\\';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        resolve(UrlGenerator::class)->forceScheme('https');

        $this->routes(function () {
            Route::middleware('web')->namespace(self::ROOT . 'Web')->group(base_path('routes/web.php'));
        });

        $router = app('Dingo\Api\Routing\Router');

        /** @var Router $router */
        $router->version('v1', function (Router $api) {
            require base_path('routes/api.php');
        });
    }
}
