<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\Changelogs\Saving as ChangelogSaving;
use App\Events\ModelSaved;
use App\Events\Users\Admins\Created as AdminCreated;
use App\Events\Users\Admins\Saving as AdminSaving;
use App\Events\Users\Admins\Updated as AdminUpdated;
use App\Events\Users\Recruiters\Created as RecruiterCreated;
use App\Events\Users\Recruiters\Saving as RecruiterSaving;
use App\Events\Users\Technicians\Saving as TechnicianSaving;
use App\Listeners\Changelogs\Saving as ChangelogSavingListener;
use App\Listeners\ModelSaved as ModelSavedListener;
use App\Listeners\Users\Admins\Created as AdminCreatedListener;
use App\Listeners\Users\Admins\Saving as AdminSavingListener;
use App\Listeners\Users\Admins\Updated as AdminUpdatedListener;
use App\Listeners\Users\Recruiters\Created as RecruiterCreatedListener;
use App\Listeners\Users\Recruiters\Saving as RecruiterSavingListener;
use App\Listeners\Users\Technicians\Saving as TechnicianSavingListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ModelSaved::class       => [ModelSavedListener::class],
        AdminSaving::class      => [AdminSavingListener::class],
        AdminCreated::class     => [AdminCreatedListener::class],
        AdminUpdated::class     => [AdminUpdatedListener::class],
        RecruiterSaving::class  => [RecruiterSavingListener::class],
        ChangelogSaving::class  => [ChangelogSavingListener::class],
        TechnicianSaving::class => [TechnicianSavingListener::class],
        RecruiterCreated::class => [RecruiterCreatedListener::class],
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
