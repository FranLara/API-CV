<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Admins\Mapper;
use App\Services\Users\Admins\Saver;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use Tests\Unit\Services\Users\SaverTests;

class SaverTest extends SaverTests
{
    private const string PSSWD = 'test_psswd';
    private const string USERNAME = 'test_username';
    private const string LANGUAGE = 'test_language';

    /**
     * @throws Exception
     */
    #[DataProvider('providerUser')]
    public function testSave(bool $existing, bool $modified = false): void
    {
        $mapper = $this->createConfiguredMock(Mapper::class, ['map' => $this->getAdmin($existing, $modified)]);
        new Saver($mapper)->save(new AdminDTO());
        $admin = Admin::whereUsername(self::USERNAME)->first();

        $this->assertSame(self::USERNAME, $admin->username);
        $this->assertSame($this->getExpectedField(self::LANGUAGE, $modified), $admin->language);
        $this->assertTrue(Hash::check($this->getExpectedField(self::PSSWD, $modified), $admin->password));
    }

    public static function providerUser(): array
    {
        return [[false], [true], [true, true]];
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
}
