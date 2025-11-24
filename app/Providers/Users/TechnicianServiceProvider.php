<?php

declare(strict_types=1);

namespace App\Providers\Users;

use App\Services\Mapper;
use App\Services\Users\Technicians\Mapper as TechniciansMapper;
use App\Services\Users\Technicians\Saver as TechnicianSaver;
use Illuminate\Support\ServiceProvider;

class TechnicianServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(TechnicianSaver::class)->needs(Mapper::class)->give(TechniciansMapper::class);
    }

    public function boot(): void
    {
    }
}
