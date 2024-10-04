<?php
declare(strict_types = 1);

namespace Tests\Feature\Commands\User\Admin;

use Tests\Feature\Commands\User\UserTests;

abstract class AdminTests extends UserTests
{
	protected const string ADMIN_SIGNATURE = 'Admin';
	protected const string ADMIN_TRANSLATIONS = self::TRANSLATIONS . 'admin.';
}
