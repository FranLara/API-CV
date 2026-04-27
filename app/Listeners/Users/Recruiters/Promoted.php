<?php

declare(strict_types=1);

namespace App\Listeners\Users\Recruiters;

use App\Events\Users\Recruiters\Promoted as RecruiterPromotedEvent;
use App\Listeners\Listener;
use App\Notifications\User\Recruiter\Promoted as RecruiterPromotedNotification;
use App\Utils\Notifications as NotificationUtils;

class Promoted extends Listener
{
    use NotificationUtils;

    public function handle(RecruiterPromotedEvent $event): void
    {
        $recruiter = $event->recruiter;
        $notification = new RecruiterPromotedNotification($recruiter);
        $this->sendMailNotification($notification, $recruiter->getLanguage(), $recruiter->getEmail());
    }
}
