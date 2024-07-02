<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Admin;
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    private const string PSSWD = 'test_psswd';
    private const string USERNAME = 'test_username';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';

    /**
     * @dataProvider providerConstructorData
     */
    public function testConstructor(
        ?string $psswd = null,
        ?string $username = null,
        ?string $language = null,
        ?string $identifier = null
    ): void {
        $admin = new Admin(identifier: $identifier, username: $username, psswd: $psswd, language: $language);

        $this->assertSame($psswd, $admin->getPsswd());
        $this->assertSame($username, $admin->getUsername());
        $this->assertSame($language, $admin->getLanguage());
        $this->assertSame($identifier, $admin->getIdentifier());
    }

    /**
     * @dataProvider providerGetUsername
     */
    public function testGetUsername(string $username = null): void
    {
        $admin = new Admin(username: $username);

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
        return [
            [],
            [self::PSSWD],
            [null, self::USERNAME],
            [null, null, self::LANGUAGE],
            [null, null, null, self::IDENTIFIER],
            [self::PSSWD, null, null, self::IDENTIFIER],
            [null, self::USERNAME, null, self::IDENTIFIER],
            [null, null, self::LANGUAGE, self::IDENTIFIER],
            [self::PSSWD, null, self::LANGUAGE, self::IDENTIFIER],
            [null, self::USERNAME, self::LANGUAGE, self::IDENTIFIER],
            [self::PSSWD, self::USERNAME, self::LANGUAGE, self::IDENTIFIER]
        ];
    }

    public static function providerGetUsername(): array
    {
        return [[], [self::USERNAME]];
    }

    public static function providerSetUsername(): array
    {
        return [[self::USERNAME]];
    }
}
