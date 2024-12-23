<?php

declare(strict_types=1);

namespace App\Listeners;

use App\BusinessObjects\DTOs\Changelog;
use App\Events\ModelSaved as ModelSavedEvent;
use App\Services\Changelogs\Saver;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class ModelSaved implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    public function __construct(private Saver $saver)
    {
    }

    public function handle(ModelSavedEvent $event): void
    {
        $changelog = new Changelog(entityId: $event->model->id, type: get_class($event->model),
            valuePayload: $event->model->toJson());

        $this->saver->save($changelog);
    }
}
