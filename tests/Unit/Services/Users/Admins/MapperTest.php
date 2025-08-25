<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Admins\Mapper;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Tests\Utils\DTOs\SetGenerator;

class MapperTest extends TestCase
{
    private const string PSSWD = 'test_psswd';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';

    private const array VALUES = [self::LANGUAGE, self::PSSWD, self::IDENTIFIER];

    #[DataProvider('providerAdminData')]
    public function testMap(?string $language = null, ?string $psswd = null, ?string $identifier = null): void
    {
        $admin = new AdminDTO(language: $language, psswd: $psswd, identifier: $identifier);
        $admin = new Mapper()->map($admin, new Admin());

        $this->assertSame($language, $admin->language);
        if (!empty($psswd)) {
            $this->assertTrue(Hash::check($psswd, $admin->password));
        }
        if (empty($identifier)) {
            $this->assertGreaterThan(now()->subMinute(), $admin->created_at);
        }
    }

    public static function providerAdminData(): array
    {
        return array_merge(
            [self::VALUES],
            [[null, null, null]],
            SetGenerator::generate(self::VALUES, 1),
            SetGenerator::generate(self::VALUES, 2),
        );
    }
}
