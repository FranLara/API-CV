<?php

declare(strict_types=1);

namespace App\Providers;

use App\Console\Commands\User\Admin\Create;
use App\Console\Commands\User\Admin\Update;
use App\Services\Retriever;
use App\Services\Saver;
use App\Services\Users\Admins\Saver as AdminSaver;
use App\Services\Users\Admins\Retriever as AdminRetriever;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->bindUserCommands();
    }

    public function boot(): void
    {
    }

    private function bindUserCommands(): void
    {
        $this->app->when(Create::class)->needs(Saver::class)->give(AdminSaver::class);
        $this->app->when(Create::class)->needs(Retriever::class)->give(AdminRetriever::class);

        $this->app->when(Update::class)->needs(Saver::class)->give(AdminSaver::class);
        $this->app->when(Update::class)->needs(Retriever::class)->give(AdminRetriever::class);
    }
}
