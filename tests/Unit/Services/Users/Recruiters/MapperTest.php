<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Recruiters\Mapper;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MapperTest extends TestCase
{
    private const string NAME = 'test_name';
    private const string PSSWD = 'test_psswd';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';
    private const string LINKEDIN_PROFILE = 'test_linkedin_profile';

    /**
     * @dataProvider providerRecruiterData
     */
    public function testMap(
        ?string $name = null,
        ?string $psswd = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $linkedinProfile = null
    ): void {
        $recruiter = (new Mapper())->map(new RecruiterDTO(identifier: $identifier, name: $name, psswd: $psswd,
            language: $language, linkedinProfile: $linkedinProfile,), new Recruiter());

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
        return [
            [],
            [self::NAME],
            [null, self::PSSWD],
            [null, null, self::LANGUAGE],
            [null, null, null, self::IDENTIFIER],
            [null, null, null, null, self::LINKEDIN_PROFILE],

            [self::NAME, self::PSSWD],
            [self::NAME, null, self::LANGUAGE],
            [self::NAME, null, null, self::IDENTIFIER],
            [self::NAME, null, null, null, self::LINKEDIN_PROFILE],

            [null, self::PSSWD, self::LANGUAGE],
            [null, self::PSSWD, null, self::IDENTIFIER],
            [null, self::PSSWD, null, null, self::LINKEDIN_PROFILE],
            [null, null, self::LANGUAGE, self::IDENTIFIER],
            [null, null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, null, null, self::IDENTIFIER, self::LINKEDIN_PROFILE],
            [self::NAME, self::PSSWD, self::LANGUAGE],
            [self::NAME, self::PSSWD, null, self::LINKEDIN_PROFILE],
            [self::NAME, self::PSSWD, null, null, self::LINKEDIN_PROFILE],

            [null, self::PSSWD, self::LANGUAGE, self::IDENTIFIER],
            [null, self::PSSWD, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, null, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [self::NAME, self::PSSWD, self::LANGUAGE, self::IDENTIFIER],
            [self::NAME, self::PSSWD, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [self::NAME, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE]
        ];
    }
}
