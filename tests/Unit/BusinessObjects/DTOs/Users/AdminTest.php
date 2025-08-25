<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Admin;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Utils\DTOs\SetGenerator;

class AdminTest extends UserTests
{
    private const string USERNAME = 'test_username';

    private const array VALUES = [self::PSSWD, self::USERNAME, self::LANGUAGE, self::IDENTIFIER];

    #[DataProvider('providerConstructorData')]
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

    #[DataProvider('providerGetUsername')]
    public function testGetUsername(?string $username = null): void
    {
        $admin = new Admin(username: $username);

        if (!is_null($username)) {
            $this->assertIsString($admin->getUsername());
        }
        $this->assertSame($username, $admin->getUsername());
    }

    #[DataProvider('providerSetUsername')]
    public function testSetUsername(?string $username): void
    {
        $admin = new Admin();
        $admin->setUsername($username);

        $this->assertSame($username, $admin->getUsername());
    }

    public static function providerConstructorData(): array
    {
        return array_merge(
            [self::VALUES],
            [[null, null, null, null]],
            SetGenerator::generate(self::VALUES, 1),
            SetGenerator::generate(self::VALUES, 2),
            SetGenerator::generate(self::VALUES, 3),
        );
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
