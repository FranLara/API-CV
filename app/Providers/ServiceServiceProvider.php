<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Changelogs\Mapper as ChangelogMapper;
use App\Services\Changelogs\Saver as ChangelogSaver;
use App\Services\Mapper;
use App\Services\Saver;
use App\Services\Transformer;
use App\Services\Users\Admins\Mapper as AdminMapper;
use App\Services\Users\Admins\Retriever as AdminRetriever;
use App\Services\Users\Admins\Saver as AdminSaver;
use App\Services\Users\Admins\Transformer as AdminTransformer;
use App\Services\Users\Recruiters\Creator;
use App\Services\Users\Recruiters\Mapper as RecruiterMapper;
use App\Services\Users\Recruiters\Retriever as RecruiterRetriever;
use App\Services\Users\Recruiters\Saver as RecruiterSaver;
use App\Services\Users\Recruiters\Transformer as RecruiterTransformer;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(ChangelogSaver::class)->needs(Mapper::class)->give(ChangelogMapper::class);

        $this->bindUserServices();
    }

    public function boot(): void
    {
    }

    private function bindUserServices(): void
    {
        $this->app->when(AdminSaver::class)->needs(Mapper::class)->give(AdminMapper::class);
        $this->app->when(AdminRetriever::class)->needs(Transformer::class)->give(AdminTransformer::class);

        $this->app->when(Creator::class)->needs(Saver::class)->give(RecruiterSaver::class);
        $this->app->when(RecruiterSaver::class)->needs(Mapper::class)->give(RecruiterMapper::class);
        $this->app->when(RecruiterRetriever::class)->needs(Transformer::class)->give(RecruiterTransformer::class);
    }
}
