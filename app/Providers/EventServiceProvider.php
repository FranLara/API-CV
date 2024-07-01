<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\Changelogs\Saving as ChangelogSaving;
use App\Events\ModelSaved;
use App\Events\Users\Admins\Saving as AdminSaving;
use App\Events\Users\Recruiters\Created as RecruiterCreatedEvent;
use App\Events\Users\Recruiters\Saving as RecruiterSaving;
use App\Listeners\Changelogs\Saving as ChangelogSavingListener;
use App\Listeners\ModelSaved as ModelSavedListener;
use App\Listeners\Users\Admins\Saving as AdminSavingListener;
use App\Listeners\Users\Recruiters\Created as RecruiterCreatedListener;
use App\Listeners\Users\Recruiters\Saving as RecruiterSavingListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ModelSaved::class            => [ModelSavedListener::class],
        AdminSaving::class           => [AdminSavingListener::class],
        RecruiterSaving::class       => [RecruiterSavingListener::class],
        ChangelogSaving::class       => [ChangelogSavingListener::class],
        RecruiterCreatedEvent::class => [RecruiterCreatedListener::class]
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
