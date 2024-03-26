<?php
declare(strict_types = 1);

namespace Tests\Feature\Commands\User;

use Tests\Feature\FeatureTest;

abstract class UserTest extends FeatureTest
{
	protected const EXIT = 'exit';
	protected const USER_SIGNATURE = 'user:';
	protected const TRANSLATIONS = 'command.user.';
}
