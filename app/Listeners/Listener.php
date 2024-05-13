<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Listener implements ShouldQueue, ShouldHandleEventsAfterCommit
{
    public string $queue = 'listeners';
}