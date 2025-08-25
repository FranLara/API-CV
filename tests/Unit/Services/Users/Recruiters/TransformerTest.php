<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\Services\Users\Recruiters\Transformer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Utils\DTOs\SetGenerator;

class TransformerTest extends TestCase
{
    private const string NAME = 'test_name';
    private const string EMAIL = 'test_email';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';
    private const string LINKEDIN_PROFILE = 'test_linkedin_profile';

    private const array VALUES = [self::NAME, self::EMAIL, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE];

    #[DataProvider('providerRecruiterData')]
    public function testTransform(
        ?string $name = null,
        ?string $email = null,
        ?string $language = null,
        ?string $identifier = null,
        ?string $linkedinProfile = null
    ): void {
        $recruiter = new Transformer()->transform(
            $this->getModel($email, $name, $language, $linkedinProfile, $identifier)
        );

        $this->assertSame($name, $recruiter->getName());
        $this->assertSame($email, $recruiter->getEmail());
        $this->assertSame($language, $recruiter->getLanguage());
        $this->assertSame($identifier, $recruiter->getIdentifier());
        $this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
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

    private function getModel(
        ?string $email,
        ?string $name,
        ?string $language,
        ?string $linkedinProfile,
        ?string $identifier
    ): RecruiterModel {
        $recruiter = [
            'email'            => $email,
            'name'             => $name,
            'language'         => $language,
            'linkedin_profile' => $linkedinProfile,
            'id'               => $identifier,
        ];

        return new RecruiterModel($recruiter);
    }
}
