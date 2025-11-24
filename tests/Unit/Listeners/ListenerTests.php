<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners;

use App\Events\ModelSaved;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

abstract class ListenerTests extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake([ModelSaved::class]);
    }
}
