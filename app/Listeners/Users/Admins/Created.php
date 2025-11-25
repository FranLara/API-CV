<?php

declare(strict_types=1);

namespace App\Listeners\Users\Admins;

use App\Events\Users\Admins\Created as AdminCreatedEvent;
use App\Listeners\Listener;
use App\Notifications\User\Admin\Created as AdminCreatedNotification;
use App\Utils\Notifications as NotificationUtils;

class Created extends Listener
{
    use NotificationUtils;

    public function handle(AdminCreatedEvent $event): void
    {
        $this->sendMailNotification(new AdminCreatedNotification($event->admin), $event->admin->getLanguage());
    }
}
