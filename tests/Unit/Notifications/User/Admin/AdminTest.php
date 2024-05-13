<?php
declare(strict_types = 1);

namespace Tests\Unit\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

abstract class AdminTest extends TestCase
{
	protected const string USERNAME = 'test_username';

	protected function getAdmin(string $language): Admin
	{
		$admin = new Admin(self::USERNAME, $language);
		Lang::setLocale($admin->getLanguage());

		return $admin;
	}
}
