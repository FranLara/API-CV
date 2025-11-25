<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Events\Users\Admins\Updated as AdminUpdatedEvent;
use App\Listeners\Users\Admins\Updated;
use Tests\Unit\Listeners\ListenerTests;

class UpdatedTest extends ListenerTests
{
    public function testHandle(): void
    {
        new Updated()->handle(new AdminUpdatedEvent(new Admin()));

        $this->assertDatabaseCount('jobs', 1);
        $this->assertDatabaseHas('jobs', ['queue' => 'notifications']);
    }
}
