<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\RecruiterCreated as RecruiterCreatedEvent;
use App\Notifications\User\Recruiter\Created;
use App\Notifications\User\Recruiter\Psswd;
use App\Utils\Notifications as NotificationUtils;

class RecruiterCreated extends Listener
{
    use NotificationUtils;

    public function handle(RecruiterCreatedEvent $event): void
    {
        $recruiter = $event->recruiter;
        $this->sendMailNotification(new Created($recruiter));
        $this->sendMailNotification(new Psswd($recruiter), $recruiter->getLanguage(), $recruiter->getEmail());
    }
}
