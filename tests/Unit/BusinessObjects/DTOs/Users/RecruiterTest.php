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
        $values = [self::NAME, self::EMAIL, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE];

        return array_merge(
            [$values],
            [[null, null, null, null, null, null]],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
            SetGenerator::generate($values, 3),
            SetGenerator::generate($values, 4),
            SetGenerator::generate($values, 5),
        );
    }
}
