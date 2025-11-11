<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Changelogs\Mapper as ChangelogMapper;
use App\Services\Changelogs\Saver as ChangelogSaver;
use App\Services\Mapper;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ChangelogSaver::class)->needs(Mapper::class)->give(ChangelogMapper::class);
    }

    public function boot(): void
    {
    }
}
