<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Recruiter;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Utils\DTOs\Recruiter as RecruiterUtils;
use Tests\Utils\DTOs\SetGenerator;

class RecruiterTest extends UserTests
{
    use RecruiterUtils;

    private const array VALUES = [
        self::NAME,
        self::EMAIL,
        self::PSSWD,
        self::LANGUAGE,
        self::IDENTIFIER,
        self::LINKEDIN_PROFILE,
    ];

    #[DataProvider('providerConstructorData')]
    public function testConstructor(
        ?string $name = null,
        ?string $email = null,
        ?string $psswd = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $linkedinProfile = null
    ): void {
        $recruiter = new Recruiter(
            name: $name,
            email: $email,
            psswd: $psswd,
            language: $language,
            identifier: $identifier,
            linkedinProfile: $linkedinProfile
        );

        $this->assertSame($name, $recruiter->getName());
        $this->assertSame($email, $recruiter->getEmail());
        $this->assertSame($psswd, $recruiter->getPsswd());
        $this->assertSame($language, $recruiter->getLanguage());
        $this->assertSame($identifier, $recruiter->getIdentifier());
        $this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
    }

    public static function providerConstructorData(): array
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
