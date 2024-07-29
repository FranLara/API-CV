<?php

declare(strict_types=1);

namespace App\Listeners\Changelogs;

use App\Events\Changelogs\Saving as ChangelogSavingEvent;
use App\Utils\Errors as ErrorUtils;

class Saving
{
    use ErrorUtils;

    public function handle(ChangelogSavingEvent $event): bool
    {
        $errorMessages = '';

        if (!json_validate($event->changelog->value_payload)) {
            $errorMessages .= '- The value payload does not have a JSON format.' . PHP_EOL;
        }

        if (!in_array($event->changelog->type, $event->changelog::ENTITY_TYPES, true)) {
            $errorMessages .= $this->getCollectionErrorMessage('type', collect($event->changelog::ENTITY_TYPES),
                $event->changelog->type);
        }

        if (!empty($errorMessages)) {
            return false;
        }

        return true;
    }
}
