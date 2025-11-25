<?php

declare(strict_types=1);

namespace App\Listeners\Users\Admins;

use App\Events\Users\Admins\Updated as AdminUpdatedEvent;
use App\Listeners\Listener;
use App\Notifications\User\Admin\Updated as AdminUpdatedNotification;
use App\Utils\Notifications as NotificationUtils;

class Updated extends Listener
{
    use NotificationUtils;

    public function handle(AdminUpdatedEvent $event): void
    {
        $this->sendMailNotification(new AdminUpdatedNotification($event->admin), $event->admin->getLanguage());
    }
}
