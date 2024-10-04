<?php

declare(strict_types=1);

namespace App\Listeners\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter;
use App\Events\Users\Recruiters\Saving as RecruiterSavingEvent;

class Saving
{
    public function handle(RecruiterSavingEvent $event): bool
    {
        $errorMessages = '';

        $checkRecruiter = Recruiter::whereEmail($event->recruiter->email)->first();
        if ((!empty($checkRecruiter))
            && ((empty($event->recruiter->id))
                || ((!empty($event->recruiter->id))
                    && ($event->recruiter->id != $checkRecruiter->id)))) {
            $errorMessages .= sprintf('The email "%s" already exists.' . PHP_EOL, $event->recruiter->email);
        }

        if (!empty($errorMessages)) {
            return false;
        }

        return true;
    }
}
