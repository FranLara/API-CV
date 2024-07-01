<?php

declare(strict_types=1);

namespace App\Listeners\Changelogs;

use App\Events\Changelogs\Saving as ChangelogSavingEvent;

class Saving
{
    public function handle(ChangelogSavingEvent $event): bool
    {
        return true;
    }
}
