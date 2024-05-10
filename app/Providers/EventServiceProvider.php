<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ModelSaved;
use App\Events\RecruiterCreated;
use App\Listeners\ModelSaved as ModelSavedListener;
use App\Listeners\RecruiterCreated as RecruiterCreatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ModelSaved::class       => [ModelSavedListener::class],
        RecruiterCreated::class => [RecruiterCreatedListener::class]
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
