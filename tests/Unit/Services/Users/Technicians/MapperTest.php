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

    private const string GITHUB_PROFILE = 'test_github_profile';

    private const array VALUES = [
        self::NAME,
        self::PSSWD,
        self::LANGUAGE,
        self::IDENTIFIER,
        self::GITHUB_PROFILE,
        self::LINKEDIN_PROFILE,
    ];

    #[DataProvider('providerTechnicianData')]
    public function testMap(
        ?string $name = null,
        ?string $psswd = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $githubProfile = null,
        ?string $linkedinProfile = null
    ): void {
        $technician = new TechnicianDTO(
            name: $name,
            psswd: $psswd,
            language: $language,
            identifier: $identifier,
            githubProfile: $githubProfile,
            linkedinProfile: $linkedinProfile
        );
        $technician = new Mapper()->map($technician, new Technician());

        $this->assertSame($name, $technician->name);
        $this->assertSame($language, $technician->language);
        $this->assertSame($githubProfile, $technician->github_profile);
        $this->assertSame($linkedinProfile, $technician->linkedin_profile);
        if (!empty($psswd)) {
            $this->assertTrue(Hash::check($psswd, $technician->password));
        }
        if (empty($identifier)) {
            $this->assertGreaterThan(now()->subMinute(), $technician->created_at);
        }
    }

    public static function providerTechnicianData(): array
    {
        return array_merge(
            [self::VALUES],
            [[null, null, null, null, null, null]],
            SetGenerator::generate(self::VALUES, 1),
            SetGenerator::generate(self::VALUES, 2),
            SetGenerator::generate(self::VALUES, 3),
            SetGenerator::generate(self::VALUES, 4),
            SetGenerator::generate(self::VALUES, 5),
        );
    }
}
