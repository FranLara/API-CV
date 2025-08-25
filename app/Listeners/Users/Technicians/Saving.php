<?php

declare(strict_types=1);

namespace App\Listeners\Users\Technicians;

use App\BusinessObjects\Models\Users\Technician;
use App\Events\Users\Technicians\Saving as TechnicianSavingEvent;

class Saving
{
    public function handle(TechnicianSavingEvent $event): bool
    {
        $errorMessages = '';

        $checkTechnician = Technician::whereEmail($event->technician->email)->first();
        if ((!empty($checkTechnician))
            && ((empty($event->technician->id))
                || (($event->technician->id !== $checkTechnician->id)))) {
            $errorMessages .= sprintf('The email "%s" already exists.' . PHP_EOL, $event->technician->email);
        }

        if (!empty($errorMessages)) {
            return false;
        }

        return true;
    }
}
