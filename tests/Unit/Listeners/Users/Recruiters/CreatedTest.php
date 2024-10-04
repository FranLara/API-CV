<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Events\Users\Recruiters\Created as RecruiterCreatedEvent;
use App\Listeners\Users\Recruiters\Created;
use Tests\Unit\Listeners\ListenerTests;

class CreatedTest extends ListenerTests
{
    public function testHandle(): void
    {
        (new Created())->handle(new RecruiterCreatedEvent(new Recruiter()));

        $this->assertDatabaseCount('jobs', 2);
        $this->assertDatabaseHas('jobs', ['queue' => 'notifications']);
    }
}
