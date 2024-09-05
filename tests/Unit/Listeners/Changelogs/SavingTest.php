<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Changelogs;

use App\BusinessObjects\Models\Changelog;
use App\Events\Changelogs\Saving as SavingEvent;
use App\Listeners\Changelogs\Saving;
use Tests\Unit\Listeners\ListenerTest;

class SavingTest extends ListenerTest
{
    public function testHandle(): void
    {
        /** @var Changelog $changelog */
        $changelog = Changelog::factory();
        (new Saving())->handle(new SavingEvent($changelog));

        $this->assertDatabaseCount('jobs', 2);
        $this->assertDatabaseHas('jobs', ['queue' => 'notifications']);
    }
}
