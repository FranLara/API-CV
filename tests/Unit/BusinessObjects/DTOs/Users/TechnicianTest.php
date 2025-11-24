<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Technician;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Utils\DTOs\Recruiter as RecruiterUtils;
use Tests\Utils\DTOs\SetGenerator;

class TechnicianTest extends UserTests
{
    use RecruiterUtils;

    private const string GITHUB_PROFILE = 'test_github_profile';

    #[DataProvider('providerConstructorData')]
    public function testConstructor(
        ?string $name = null,
        ?string $email = null,
        ?string $psswd = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $githubProfile = null,
        ?string $linkedinProfile = null
    ): void {
        $technician = new Technician(
            name: $name,
            email: $email,
            psswd: $psswd,
            language: $language,
            identifier: $identifier,
            githubProfile: $githubProfile,
            linkedinProfile: $linkedinProfile
        );

        $this->assertSame($name, $technician->getName());
        $this->assertSame($email, $technician->getEmail());
        $this->assertSame($psswd, $technician->getPsswd());
        $this->assertSame($language, $technician->getLanguage());
        $this->assertSame($identifier, $technician->getIdentifier());
        $this->assertSame($githubProfile, $technician->getGithubProfile());
        $this->assertSame($linkedinProfile, $technician->getLinkedinProfile());
    }

    #[DataProvider('providerGetGithubProfile')]
    public function testGetUsername(?string $githubProfile = null): void
    {
        $technician = new Technician(githubProfile: $githubProfile);

        if (!is_null($githubProfile)) {
            $this->assertIsString($technician->getGithubProfile());
        }
        $this->assertSame($githubProfile, $technician->getGithubProfile());
    }

    #[DataProvider('providerSetGithubProfile')]
    public function testSetUsername(?string $githubProfile): void
    {
        $technician = new Technician();
        $technician->setGithubProfile($githubProfile);

        $this->assertSame($githubProfile, $technician->getGithubProfile());
    }

    public static function providerConstructorData(): array
    {
        $values = [
            self::NAME,
            self::EMAIL,
            self::PSSWD,
            self::LANGUAGE,
            self::IDENTIFIER,
            self::GITHUB_PROFILE,
            self::LINKEDIN_PROFILE,
        ];

        return array_merge(
            [$values],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
            SetGenerator::generate($values, 3),
            SetGenerator::generate($values, 4),
            SetGenerator::generate($values, 5),
            SetGenerator::generate($values, 6),
            [[null, null, null, null, null, null, null]],
        );
    }

    public static function providerGetGithubProfile(): array
    {
        return [[null], [self::GITHUB_PROFILE]];
    }

    public static function providerSetGithubProfile(): array
    {
        return [[self::GITHUB_PROFILE]];
    }
}
