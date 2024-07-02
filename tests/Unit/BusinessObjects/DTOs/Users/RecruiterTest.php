<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Recruiter;
use PHPUnit\Framework\TestCase;

class RecruiterTest extends TestCase
{
    private const string NAME = 'test_name';
    private const string EMAIL = 'test_email';
    private const string PSSWD = 'test_psswd';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';
    private const string LINKEDIN_PROFILE = 'test_linkedin_profile';

    /**
     * @dataProvider providerConstructorData
     */
    public function testConstructor(
        ?string $name = null,
        ?string $email = null,
        ?string $psswd = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $linkedinProfile = null
    ): void {
        $recruiter = new Recruiter(identifier: $identifier, name: $name, email: $email, psswd: $psswd,
            language: $language, linkedinProfile: $linkedinProfile);

        $this->assertSame($name, $recruiter->getName());
        $this->assertSame($email, $recruiter->getEmail());
        $this->assertSame($psswd, $recruiter->getPsswd());
        $this->assertSame($language, $recruiter->getLanguage());
        $this->assertSame($identifier, $recruiter->getIdentifier());
        $this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
    }

    public static function providerConstructorData(): array
    {
        return [
            [],
            [self::NAME],
            [null, self::EMAIL],
            [null, null, self::PSSWD],
            [null, null, null, self::LANGUAGE],
            [null, null, null, null, self::IDENTIFIER],
            [null, null, null, null, null, self::LINKEDIN_PROFILE],

            [self::NAME, self::EMAIL],
            [self::NAME, null, self::PSSWD],
            [self::NAME, null, null, self::LANGUAGE],
            [self::NAME, null, null, null, self::IDENTIFIER],
            [self::NAME, null, null, null, null, self::LINKEDIN_PROFILE],
            [null, self::EMAIL, self::PSSWD],
            [null, self::EMAIL, null, self::LANGUAGE],
            [null, self::EMAIL, null, null, self::IDENTIFIER],
            [null, self::EMAIL, null, null, null, self::LINKEDIN_PROFILE],
            [null, null, self::PSSWD, self::LANGUAGE],
            [null, null, self::PSSWD, null, self::IDENTIFIER],
            [null, null, self::PSSWD, null, null, self::LINKEDIN_PROFILE],

            [null, null, null, self::LANGUAGE, self::IDENTIFIER],
            [null, null, null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, null, null, null, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [self::NAME, self::EMAIL, self::PSSWD],
            [self::NAME, self::EMAIL, null, self::LANGUAGE],
            [self::NAME, self::EMAIL, null, null, self::IDENTIFIER],
            [self::NAME, self::EMAIL, null, null, null, self::LINKEDIN_PROFILE],

            [self::NAME, null, self::PSSWD, self::LANGUAGE],
            [self::NAME, null, self::PSSWD, null, self::IDENTIFIER],
            [self::NAME, null, self::PSSWD, null, null, self::LINKEDIN_PROFILE],

            [self::NAME, null, null, self::LANGUAGE, self::IDENTIFIER],
            [self::NAME, null, null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [self::NAME, null, null, null, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [null, self::EMAIL, self::PSSWD, self::LANGUAGE],
            [null, self::EMAIL, self::PSSWD, null, self::IDENTIFIER],
            [null, self::EMAIL, self::PSSWD, null, null, self::LINKEDIN_PROFILE],

            [null, self::EMAIL, null, self::LANGUAGE, self::IDENTIFIER],
            [null, self::EMAIL, null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, self::EMAIL, null, null, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [null, null, self::PSSWD, self::LANGUAGE, self::IDENTIFIER],
            [null, null, self::PSSWD, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, null, null, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [self::NAME, self::EMAIL, self::PSSWD, self::LANGUAGE],
            [self::NAME, self::EMAIL, self::PSSWD, null, self::IDENTIFIER],
            [self::NAME, self::EMAIL, self::PSSWD, null, null, self::LINKEDIN_PROFILE],

            [null, self::EMAIL, self::PSSWD, self::LANGUAGE, self::IDENTIFIER],
            [null, self::EMAIL, self::PSSWD, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, null, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [self::NAME, self::EMAIL, self::PSSWD, self::LANGUAGE, self::IDENTIFIER],
            [self::NAME, self::EMAIL, self::PSSWD, self::LANGUAGE, null, self::LINKEDIN_PROFILE],

            [null, self::EMAIL, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE],

            [self::NAME, self::EMAIL, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE]
        ];
    }
}
