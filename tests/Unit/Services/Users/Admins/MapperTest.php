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
    #[DataProvider('providerAdmin')]
    public function testMap(AdminDTO $dto): void
    {
        $admin = new Mapper()->map($dto, new Admin());

        $this->assertSame($dto->getLanguage(), $admin->language);
        if (!empty($dto->getPsswd())) {
            $this->assertTrue(Hash::check($dto->getPsswd(), $admin->password));
        }
        if (empty($dto->getIdentifier())) {
            $this->assertGreaterThan(now()->subMinute(), $admin->created_at);
        }
    }

    public static function providerAdmin(): array
    {
        $values = ['test_language', 'test_psswd', 'test_identifier'];

        $adminValues = array_merge(
            [$values],
            [[null, null, null]],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
        );

        $tests = [];
        foreach ($adminValues as $values) {
            $tests[] = [new AdminDTO(language: $values[0], psswd: $values[1], identifier: $values[2])];
        }

        return $tests;
    }
}
