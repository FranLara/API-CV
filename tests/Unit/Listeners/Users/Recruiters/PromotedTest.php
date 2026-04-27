<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Events\Users\Recruiters\Promoted as RecruiterPromotedEvent;
use App\Listeners\Users\Recruiters\Promoted;
use Tests\Unit\Listeners\ListenerTests;

class PromotedTest extends ListenerTests
{
    public function testHandle(): void
    {
        new Promoted()->handle(new RecruiterPromotedEvent(new Recruiter()));

        $this->assertDatabaseCount('jobs', 1);
        $this->assertDatabaseHas('jobs', ['queue' => 'notifications']);
    }
}
