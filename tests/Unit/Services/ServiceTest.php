<?php
declare(strict_types = 1);

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class ServiceTest extends TestCase
{
	use RefreshDatabase;
}
