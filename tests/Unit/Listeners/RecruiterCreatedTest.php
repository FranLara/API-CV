<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\Events\RecruiterCreated as RecruiterCreatedEvent;
use App\Notifications\User\Recruiter\Created;
use App\Notifications\User\Recruiter\Psswd;
use App\Utils\Notifications as NotificationUtils;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tests\TestCase;

class RecruiterCreatedTest extends TestCase
{
    use NotificationUtils;

    public string $queue = 'listeners';

    public function handle(RecruiterCreatedEvent $event): void
    {
        $recruiter = $event->recruiter;
        $this->sendMailNotification(new Created($recruiter));
        $this->sendMailNotification(new Psswd($recruiter), $recruiter->getLanguage(), $recruiter->getEmail());
    }
}
