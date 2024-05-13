<?php
declare(strict_types = 1);

namespace Tests\Unit\Listeners;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class ListenerTest extends TestCase
{
	use RefreshDatabase;
}
