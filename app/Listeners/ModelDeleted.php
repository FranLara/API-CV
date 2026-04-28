<?php

declare(strict_types=1);

namespace App\Listeners;

use App\BusinessObjects\DTOs\Changelog;
use App\BusinessObjects\Models\Changelog as ChangelogModel;
use App\Events\ModelDeleted as ModelDeletedEvent;
use App\Services\Changelogs\Saver;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class ModelDeleted implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    public function __construct(private Saver $saver)
    {
    }

    public function handle(ModelDeletedEvent $event): void
    {
        $changelog = new Changelog(
            entityId: $event->model->id,
            type: get_class($event->model),
            valuePayload: $event->model->toJson(),
            action: ChangelogModel::ACTION_DELETED,
        );

        $this->saver->save($changelog);
    }
}
