<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Events\RecruiterCreated as RecruiterCreatedEvent;
use App\Listeners\RecruiterCreated;

class RecruiterCreatedTest extends ListenerTest
{
    public function testHandle(): void
    {
        (new RecruiterCreated())->handle(new RecruiterCreatedEvent(new Recruiter()));

        $this->assertDatabaseCount('jobs', 2);
        $this->assertDatabaseHas('jobs', ['queue' => 'notifications']);
    }
}
