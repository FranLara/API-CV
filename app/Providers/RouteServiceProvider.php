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

    public function boot(): void
    {
        resolve(UrlGenerator::class)->forceScheme('https');

        $this->routes(function () {
            Route::middleware('web')->namespace(self::ROOT . 'Web')->group(base_path('routes/web.php'));
        });

        /** @var Router $router */
        $router = app('Dingo\Api\Routing\Router');
        $router->version('v1', fn(Router $api) => require base_path('routes/api.php'));
    }
}
