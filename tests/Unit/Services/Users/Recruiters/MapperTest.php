<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Recruiters\Mapper;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Tests\Utils\DTOs\SetGenerator;

class MapperTest extends TestCase
{
    private const string NAME = 'test_name';
    private const string PSSWD = 'test_psswd';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';
    private const string LINKEDIN_PROFILE = 'test_linkedin_profile';

    private const array VALUES = [self::NAME, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE];

    #[DataProvider('providerRecruiterData')]
    public function testMap(
        ?string $name = null,
        ?string $psswd = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $linkedinProfile = null
    ): void {
        $recruiter = new RecruiterDTO(
            identifier: $identifier, name: $name, psswd: $psswd, language: $language, linkedinProfile: $linkedinProfile
        );
        $recruiter = new Mapper()->map($recruiter, new Recruiter());

        $this->assertSame($name, $recruiter->name);
        $this->assertSame($language, $recruiter->language);
        $this->assertSame($linkedinProfile, $recruiter->linkedin_profile);
        if (!empty($psswd)) {
            $this->assertTrue(Hash::check($psswd, $recruiter->password));
        }
        if (empty($identifier)) {
            $this->assertGreaterThan(now()->subMinute(), $recruiter->created_at);
        }
    }

    public static function providerRecruiterData(): array
    {
        return array_merge(
            [self::VALUES],
            [[null, null, null, null, null]],
            SetGenerator::generate(self::VALUES, 1),
            SetGenerator::generate(self::VALUES, 2),
            SetGenerator::generate(self::VALUES, 3),
            SetGenerator::generate(self::VALUES, 4),
        );
    }
}
