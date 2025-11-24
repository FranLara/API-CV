<?php

declare(strict_types=1);

namespace App\Providers\Users;

use App\Services\Mapper;
use App\Services\Saver;
use App\Services\Transformer;
use App\Services\Users\Recruiters\Creator;
use App\Services\Users\Recruiters\Mapper as RecruiterMapper;
use App\Services\Users\Recruiters\Promoter;
use App\Services\Users\Recruiters\Retriever as RecruiterRetriever;
use App\Services\Users\Recruiters\Saver as RecruiterSaver;
use App\Services\Users\Recruiters\Transformer as RecruiterTransformer;
use App\Services\Users\Retriever;
use App\Services\Users\Technicians\Saver as TechnicianSaver;
use Illuminate\Support\ServiceProvider;

class RecruiterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(Creator::class)->needs(Saver::class)->give(RecruiterSaver::class);
        $this->app->when(RecruiterSaver::class)->needs(Mapper::class)->give(RecruiterMapper::class);
        $this->app->when(RecruiterRetriever::class)->needs(Transformer::class)->give(RecruiterTransformer::class);

        $this->bindPromoter();
    }

    public function boot(): void
    {
    }

    private function bindPromoter(): void
    {
        $this->app->when(Promoter::class)->needs(Saver::class)->give(TechnicianSaver::class);
        $this->app->when(Promoter::class)->needs(Retriever::class)->give(RecruiterRetriever::class);
    }
}
