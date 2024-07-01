<?php

declare(strict_types=1);

namespace App\Listeners\Users\Recruiters;

use App\Events\Users\Recruiters\Saving as RecruiterSavingEvent;

class Saving
{
    public function handle(RecruiterSavingEvent $event): bool
    {
        return true;
    }
}
