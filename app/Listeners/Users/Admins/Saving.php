<?php

declare(strict_types=1);

namespace App\Listeners\Users\Admins;

use App\Events\Users\Admins\Saving as AdminSavingEvent;

class Saving
{
    public function handle(AdminSavingEvent $event): bool
    {
        $errorMessages = '';

        if(!empty($errorMessages)){
            return false;
        }

        return true;
    }
}
