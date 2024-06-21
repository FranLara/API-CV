<?php

declare(strict_types=1);

namespace App\Listeners\Users\Recruiters;

use App\Events\Users\Recruiters\Created as RecruiterCreatedEvent;
use App\Listeners\Listener;
use App\Notifications\User\Recruiter\Created as RecruiterCreatedNotification;
use App\Notifications\User\Recruiter\Psswd;
use App\Utils\Notifications as NotificationUtils;

class Created extends Listener
{
    use NotificationUtils;

    public function handle(RecruiterCreatedEvent $event): void
    {
        $recruiter = $event->recruiter;
        $this->sendMailNotification(new RecruiterCreatedNotification($recruiter));
        $this->sendMailNotification(new Psswd($recruiter), $recruiter->getLanguage(), $recruiter->getEmail());
    }
}
