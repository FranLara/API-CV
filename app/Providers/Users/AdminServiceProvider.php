<?php

declare(strict_types=1);

namespace App\Providers\Users;

use App\Services\Mapper;
use App\Services\Transformer;
use App\Services\Users\Admins\Mapper as AdminMapper;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;
use App\Services\Users\Admins\Transformer as AdminTransformer;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(Saver::class)->needs(Mapper::class)->give(AdminMapper::class);
        $this->app->when(Retriever::class)->needs(Transformer::class)->give(AdminTransformer::class);
    }

    public function boot(): void
    {
    }
}
