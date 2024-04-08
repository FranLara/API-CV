<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\Services\Users\Recruiters\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
	private const EMAIL = 'test_email';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';
	private const LINKEDIN_PROFILE = 'test_linkedin_profile';

	/**
	 * @dataProvider providerAdminData
	 */
	public function testTransform(?string $email = null, ?string $language = null, ?string $linkedinProfile = null, ?string $identifier = null): void
	{
		$recruiter = (new Transformer())->transform($this->getModel($email, $language, $linkedinProfile, $identifier));

		$this->assertSame($email, $recruiter->getEmail());
		$this->assertSame($language, $recruiter->getLanguage());
		$this->assertSame($identifier, $recruiter->getIdentifier());
		$this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
	}

	public static function providerAdminData(): array
	{
		return [[], [self::EMAIL], [null, self::LANGUAGE], [null, null, self::LINKEDIN_PROFILE],
			[null, null, null, self::IDENTIFIER], [self::EMAIL, self::LANGUAGE],
			[self::EMAIL, null, self::LINKEDIN_PROFILE], [self::EMAIL, null, null, self::IDENTIFIER],
			[null, self::LANGUAGE, self::LINKEDIN_PROFILE], [null, self::LANGUAGE, null, self::IDENTIFIER],
			[null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::EMAIL, self::LANGUAGE, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::LANGUAGE, null, self::IDENTIFIER],
			[null, self::LANGUAGE, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::EMAIL, self::LANGUAGE, self::LINKEDIN_PROFILE, self::IDENTIFIER]];
	}

	private function getModel(?string $email, ?string $language, ?string $linkedinProfile, ?string $identifier): RecruiterModel
	{
		$model = new RecruiterModel();
		$model->id = $identifier;
		$model->email = $email;
		$model->language = $language;
		$model->linkedin_profile = $linkedinProfile;

		return $model;
	}
}
