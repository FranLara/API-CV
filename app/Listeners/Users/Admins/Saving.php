<?php

declare(strict_types=1);

namespace App\Listeners\Users\Admins;

use App\BusinessObjects\Models\Users\Admin;
use App\Events\Users\Admins\Saving as AdminSavingEvent;
use Str;

class Saving
{
    public function handle(AdminSavingEvent $event): bool
    {
        $errorMessages = '';

        $checkAdmin = Admin::whereUsername($event->admin->username)->first();
        if ((!empty($checkAdmin))
            && ((empty($event->admin->id)) || (!Str::of($event->admin->id)->exactly($checkAdmin->id)))) {
            $errorMessages .= sprintf('The username "%s" already exists.' . PHP_EOL, $event->admin->username);
        }

        if (!empty($errorMessages)) {
            return false;
        }

        return true;
    }
}
