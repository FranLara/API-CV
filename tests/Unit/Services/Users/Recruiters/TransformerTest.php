<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\Services\Users\Recruiters\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
	private const NAME = 'test_name';
	private const EMAIL = 'test_email';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';
	private const LINKEDIN_PROFILE = 'test_linkedin_profile';

	/**
	 * @dataProvider providerRecruiterData
	 */
	public function testTransform(?string $email = null, ?string $name = null, ?string $language = null, ?string $linkedinProfile = null, ?string $identifier = null): void
	{
		$recruiter = (new Transformer())->transform($this->getModel($email, $name, $language, $linkedinProfile, $identifier));

		$this->assertSame($name, $recruiter->getName());
		$this->assertSame($email, $recruiter->getEmail());
		$this->assertSame($language, $recruiter->getLanguage());
		$this->assertSame($identifier, $recruiter->getIdentifier());
		$this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
	}

	public static function providerRecruiterData(): array
	{
		return [[], [self::EMAIL], [null, self::NAME], [null, null, self::LANGUAGE],
			[null, null, null, self::LINKEDIN_PROFILE], [null, null, null, null, self::IDENTIFIER],

			[self::EMAIL, self::NAME], [self::EMAIL, null, self::LANGUAGE],
			[self::EMAIL, null, null, self::LINKEDIN_PROFILE], [self::EMAIL, null, null, null, self::IDENTIFIER],

			[null, self::NAME, self::LANGUAGE], [null, self::NAME, null, self::LINKEDIN_PROFILE],
			[null, self::NAME, null, null, self::IDENTIFIER],
			[null, null, self::LANGUAGE, self::LINKEDIN_PROFILE], [null, null, self::LANGUAGE, null, self::IDENTIFIER],

			[null, null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::EMAIL, self::NAME, self::LANGUAGE], [self::EMAIL, self::NAME, null, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::NAME, null, null, self::IDENTIFIER],

			[null, self::NAME, self::LANGUAGE, self::LINKEDIN_PROFILE],
			[null, self::NAME, self::LANGUAGE, null, self::IDENTIFIER],

			[null, null, self::LANGUAGE, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::EMAIL, self::NAME, self::LANGUAGE, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::NAME, self::LANGUAGE, null, self::IDENTIFIER],

			[null, self::NAME, self::LANGUAGE, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::EMAIL, self::NAME, self::LANGUAGE, self::LINKEDIN_PROFILE, self::IDENTIFIER]];
	}

	private function getModel(?string $email, ?string $name, ?string $language, ?string $linkedinProfile, ?string $identifier): RecruiterModel
	{
		$recruiter = ['email' => $email, 'name' => $name, 'language' => $language,
			'linkedin_profile' => $linkedinProfile, 'id' => $identifier];
		return new RecruiterModel($recruiter);
	}
}
