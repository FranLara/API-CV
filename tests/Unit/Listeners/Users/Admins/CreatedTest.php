<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Events\Users\Admins\Created as AdminCreatedEvent;
use App\Listeners\Users\Admins\Created;
use Tests\Unit\Listeners\ListenerTests;

class CreatedTest extends ListenerTests
{
    public function testHandle(): void
    {
        new Created()->handle(new AdminCreatedEvent(new Admin()));

        $this->assertDatabaseCount('jobs', 1);
        $this->assertDatabaseHas('jobs', ['queue' => 'notifications']);
    }
}
