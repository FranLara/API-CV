<?php

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Admins\Mapper;
use App\Services\Users\Admins\Saver;
use Illuminate\Support\Facades\Hash;
use Tests\Unit\Services\ServiceTest;

class SaverTest extends ServiceTest
{
	private const PSSWD = 'test_psswd';
	private const USERNAME = 'test_username';
	private const LANGUAGE = 'test_language';

	/**
	 * @dataProvider providerUser
	 */
	public function testSave(bool $existing = false, bool $modified = false): void
	{
		$mapper = $this->createConfiguredMock(Mapper::class, ['map' => $this->getAdmin($existing, $modified)]);
		(new Saver($mapper))->save(new AdminDTO());
		$admin = Admin::find(1);

		$this->assertSame(self::USERNAME, $admin->username);
		$this->assertSame($this->getExpectedField(self::LANGUAGE, $modified), $admin->language);
		$this->assertTrue(Hash::check($this->getExpectedField(self::PSSWD, $modified), $admin->password));
	}

	public static function providerUser(): array
	{
		return [[], [true], [true, true]];
	}

	private function getAdmin(bool $existing, bool $modified): Admin
	{
		$default = ['username' => self::USERNAME, 'language' => self::LANGUAGE, 'password' => Hash::make(self::PSSWD)];
		$admin = new Admin($default);

		if ($existing) {
			$admin = Admin::factory()->create($default);
		}
		if ($modified) {
			$admin->language = self::LANGUAGE . '_mod';
			$admin->password = Hash::make(self::PSSWD . '_mod');
		}

		return $admin;
	}

	private function getExpectedField(string $field, bool $modified): string
	{
		if ($modified) {
			return $field . '_mod';
		}

		return $field;
	}
}
