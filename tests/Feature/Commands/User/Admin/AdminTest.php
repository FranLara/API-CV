<?php

namespace Tests\Feature\Commands\User\Admin;

use Tests\Feature\Commands\User\UserTest;

abstract class AdminTest extends UserTest
{
	protected const ADMIN_SIGNATURE = 'Admin';
	protected const ADMIN_TRANSLATIONS = self::TRANSLATIONS . 'admin.';
}
