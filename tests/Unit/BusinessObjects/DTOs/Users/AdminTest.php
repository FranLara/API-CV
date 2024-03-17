<?php

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Admin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
	private const IDENTIFIER = 31;
	private const PSSWD = 'test_psswd';
	private const USERNAME = 'test_username';
	private const LANGUAGE = 'test_language';

	/**
	 * @dataProvider providerConstructorData
	 */
	public function testConstructor(?string $username, ?string $language, ?string $psswd, ?int $identifier): void
	{
		$admin = new Admin($username, $language, $psswd, $identifier);

		$this->assertSame($psswd, $admin->getPsswd());
		$this->assertSame($username, $admin->getUsername());
		$this->assertSame($language, $admin->getLanguage());
		$this->assertEquals($identifier, $admin->getIdentifier());
	}

	/**
	 * @dataProvider providerGetUsername
	 */
	public function testGetUsername(?string $username): void
	{
		$admin = new Admin($username);

		if (!is_null($username)) {
			$this->assertIsString($admin->getUsername());
		}
		$this->assertSame($username, $admin->getUsername());
	}

	/**
	 * @dataProvider providerSetUsername
	 */
	public function testSetUsername(?string $username): void
	{
		$admin = new Admin();
		$admin->setUsername($username);

		$this->assertSame($username, $admin->getUsername());
	}

	public static function providerConstructorData(): array
	{
		return [[null, null, null, null], [null, null, self::PSSWD, null], [self::USERNAME, null, null, null],
			[null, self::LANGUAGE, null, null], [null, null, null, self::IDENTIFIER],
			[null, null, self::PSSWD, self::IDENTIFIER], [null, self::LANGUAGE, null, self::IDENTIFIER],
			[self::USERNAME, null, null, self::IDENTIFIER], [null, self::LANGUAGE, self::PSSWD, self::IDENTIFIER],
			[self::USERNAME, null, self::PSSWD, self::IDENTIFIER],
			[self::USERNAME, self::LANGUAGE, self::PSSWD, self::IDENTIFIER]];
	}

	public static function providerGetUsername(): array
	{
		return [[null], [self::USERNAME]];
	}

	public static function providerSetUsername(): array
	{
		return [[self::USERNAME]];
	}
}
