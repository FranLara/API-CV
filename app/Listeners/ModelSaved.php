<?php

declare(strict_types=1);

namespace App\Listeners;

use App\BusinessObjects\DTOs\Changelog;
use App\Events\ModelSaved as ModelSavedEvent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;

class ModelSaved implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    public function __construct()
    {
    }

    public function handle(ModelSavedEvent $event): void
    {
        $changelog = new Changelog($event->model->id, get_class($event->model), $event->model->toJson());
    }
}
