<?php

namespace Tests\Feature\Commands\User\Admin;

use App\BusinessObjects\Models\Users\Admin;

class UpdateTest extends AdminTest
{
	private const USERNAME = 'test_username';
	private const UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';

	public function testUpdate(): void
	{
		Admin::factory()->create(['username' => self::USERNAME]);

		$this->artisan(self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE)
			->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username'), self::USERNAME)
			->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'password'), 'test_password')
			->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'language'), 1);

		$this->assertDatabaseCount('jobs', 1);
		$this->assertDatabaseCount('admins', 1);
		$this->assertDatabaseHas('admins', ['language' => 'en']);
	}

	public function testUpdateExit(): void
	{
		$this->artisan(self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE)->expectsQuestion(__(self::UPDATE_TRANSLATIONS .
			'username'), self::EXIT);

		$this->assertDatabaseCount('admins', 0);
	}

	public function testCreateNonExistingUser(): void
	{
		$this->artisan(self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE)
			->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username'), self::USERNAME)
			->expectsOutput(__(self::UPDATE_TRANSLATIONS . 'non_existing', ['username' => self::USERNAME]))
			->expectsQuestion(__(self::UPDATE_TRANSLATIONS . 'username'), self::EXIT);

		$this->assertDatabaseCount('admins', 0);
	}
}