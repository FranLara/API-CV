<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Technicians;

use App\BusinessObjects\DTOs\Users\Technician as TechnicianDTO;
use App\BusinessObjects\Models\Users\Technician;
use App\Services\Users\Technicians\Mapper;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Tests\Utils\DTOs\SetGenerator;
use Tests\Utils\Services\Users\Mapper as MapperUtils;

class MapperTest extends TestCase
{
    use MapperUtils;

    #[DataProvider('providerTechnician')]
    public function testMap(TechnicianDTO $dto): void
    {
        $technician = new Mapper()->map($dto, new Technician());

        $this->assertSame($dto->getName(), $technician->name);
        $this->assertSame($dto->getLanguage(), $technician->language);
        $this->assertSame($dto->getGithubProfile(), $technician->github_profile);
        $this->assertSame($dto->getLinkedinProfile(), $technician->linkedin_profile);
        if (!empty($dto->getPsswd())) {
            $this->assertTrue(Hash::check($dto->getPsswd(), $technician->password));
        }
        if (empty($dto->getIdentifier())) {
            $this->assertGreaterThan(now()->subMinute(), $technician->created_at);
        }
    }

    public static function providerTechnician(): array
    {
        $values = [
            self::NAME,
            self::PSSWD,
            self::LANGUAGE,
            self::IDENTIFIER,
            'test_github_profile',
            self::LINKEDIN_PROFILE,
        ];

        $technicianValues = array_merge(
            [$values],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
            SetGenerator::generate($values, 3),
            SetGenerator::generate($values, 4),
            SetGenerator::generate($values, 5),
            [[null, null, null, null, null, null]],
        );

        $tests = [];
        foreach ($technicianValues as $values) {
            $technician = new TechnicianDTO(
                name: $values[0],
                psswd: $values[1],
                language: $values[2],
                identifier: $values[3],
                githubProfile: $values[4],
                linkedinProfile: $values[5]
            );
            $tests[] = [$technician];
        }

        return $tests;
    }
}
