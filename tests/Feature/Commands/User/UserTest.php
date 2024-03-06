<?php

namespace Tests\Feature\Commands\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class UserTest extends TestCase
{
	use RefreshDatabase;
	protected const EXIT = 'exit';
	protected const USER_SIGNATURE = 'user:';
	protected const TRANSLATIONS = 'command.user.';
}
