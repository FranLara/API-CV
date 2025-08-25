<?php

declare(strict_types=1);

namespace App\Listeners\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter;
use App\Events\Users\Recruiters\Saving as RecruiterSavingEvent;
use Illuminate\Support\Str;

class Saving
{
    public function handle(RecruiterSavingEvent $event): bool
    {
        $errorMessages = $this->checkUniqueEmail($event->recruiter);

        if ((!empty($event->recruiter->linkedin_profile)) && (!Str::isUrl($event->recruiter->linkedin_profile))) {
            $msg = 'The LinkedIn profile "%s" is not a valid URL.';
            $errorMessages .= sprintf($msg . PHP_EOL, $event->recruiter->linkedin_profile);
        }

        if (!empty($errorMessages)) {
            return false;
        }

        return true;
    }

    private function checkUniqueEmail(Recruiter $recruiter): string
    {
        $errorMessages = '';

        $checkRecruiter = Recruiter::whereEmail($recruiter->email)->first();
        if ((!empty($checkRecruiter)) && ((empty($recruiter->id)) || (($recruiter->id !== $checkRecruiter->id)))) {
            $errorMessages .= sprintf('The email "%s" already exists.' . PHP_EOL, $recruiter->email);
        }

        return $errorMessages;
    }
}
