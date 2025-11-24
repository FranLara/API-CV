<?php

declare(strict_types=1);

namespace App\Providers\Users;

use App\Services\Mapper;
use App\Services\Transformer;
use App\Services\Users\Admins\Mapper as AdminMapper;
use App\Services\Users\Admins\Retriever as AdminRetriever;
use App\Services\Users\Admins\Saver as AdminSaver;
use App\Services\Users\Admins\Transformer as AdminTransformer;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(AdminSaver::class)->needs(Mapper::class)->give(AdminMapper::class);
        $this->app->when(AdminRetriever::class)->needs(Transformer::class)->give(AdminTransformer::class);
    }

    public function boot(): void
    {
    }
}
