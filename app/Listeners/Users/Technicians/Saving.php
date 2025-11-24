<?php

declare(strict_types=1);

namespace App\Listeners\Users\Technicians;

use App\BusinessObjects\Models\Users\Technician;
use App\Events\Users\Technicians\Saving as TechnicianSavingEvent;
use Illuminate\Support\Str;

class Saving
{
    public function handle(TechnicianSavingEvent $event): bool
    {
        $errorMessages = $this->checkUniqueEmail($event->technician);

        if ((!empty($event->technician->github_profile)) && (!Str::isUrl($event->technician->github_profile))) {
            $msg = 'The GitHub profile "%s" is not a valid URL.';
            $errorMessages .= sprintf($msg . PHP_EOL, $event->technician->github_profile);
        }

        if ((!empty($event->technician->linkedin_profile)) && (!Str::isUrl($event->technician->linkedin_profile))) {
            $msg = 'The LinkedIn profile "%s" is not a valid URL.';
            $errorMessages .= sprintf($msg . PHP_EOL, $event->technician->linkedin_profile);
        }

        if (!empty($errorMessages)) {
            return false;
        }

        return true;
    }

    private function checkUniqueEmail(Technician $technician): string
    {
        $errorMessages = '';

        $checkTechnician = Technician::whereEmail($technician->email)->first();
        if ((!empty($checkTechnician))
            && ((empty($technician->id)) || (!Str::of($technician->id)->exactly($checkTechnician->id)))) {
            $errorMessages .= sprintf('The email "%s" already exists.' . PHP_EOL, $technician->email);
        }

        return $errorMessages;
    }
}
