<?php
declare(strict_types = 1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Recruiter;
use PHPUnit\Framework\TestCase;

class RecruiterTest extends TestCase
{
	private const NAME = 'test_name';
	private const EMAIL = 'test_email';
	private const PSSWD = 'test_psswd';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';
	private const LINKEDIN_PROFILE = 'test_linkedin_profile';

	/**
	 * @dataProvider providerConstructorData
	 */
	public function testConstructor(?string $email = null, ?string $name = null, ?string $language = null, ?string $psswd = null, ?string $linkedinProfile = null, ?string $identifier = null): void
	{
		$recruiter = new Recruiter($email, $name, $language, $psswd, $linkedinProfile, $identifier);

		$this->assertSame($name, $recruiter->getName());
		$this->assertSame($email, $recruiter->getEmail());
		$this->assertSame($psswd, $recruiter->getPsswd());
		$this->assertSame($language, $recruiter->getLanguage());
		$this->assertSame($identifier, $recruiter->getIdentifier());
		$this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
	}

	public static function providerConstructorData(): array
	{
		return [[],
		[self::EMAIL], [null, self::NAME], [null, null, self::LANGUAGE], [null, null, null, self::PSSWD],
			[null, null, null, null, self::LINKEDIN_PROFILE], [null, null, null, null, null, self::IDENTIFIER],

			[self::EMAIL, self::NAME], [self::EMAIL, null, self::LANGUAGE], [self::EMAIL, null, null, self::PSSWD],
			[self::EMAIL, null, null, null, self::LINKEDIN_PROFILE],
			[self::EMAIL, null, null, null, null, self::IDENTIFIER],
			[null, self::NAME, self::LANGUAGE], [null, self::NAME, null, self::PSSWD],
			[null, self::NAME, null, null, self::LINKEDIN_PROFILE],
			[null, self::NAME, null, null, null, self::IDENTIFIER],
			[null, null, self::LANGUAGE, self::PSSWD], [null, null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[null, null, self::LANGUAGE, null, null, self::IDENTIFIER],

			[null, null, null, self::PSSWD, self::LINKEDIN_PROFILE],
			[null, null, null, self::PSSWD, null, self::IDENTIFIER],

			[null, null, null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::EMAIL, self::NAME, self::LANGUAGE], [self::EMAIL, self::NAME, null, self::PSSWD],
			[self::EMAIL, self::NAME, null, null, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::NAME, null, null, null, self::IDENTIFIER],

			[self::EMAIL, null, self::LANGUAGE, self::PSSWD],
			[self::EMAIL, null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[self::EMAIL, null, self::LANGUAGE, null, null, self::IDENTIFIER],

			[self::EMAIL, null, null, self::PSSWD, self::LINKEDIN_PROFILE],
			[self::EMAIL, null, null, self::PSSWD, null, self::IDENTIFIER],

			[self::EMAIL, null, null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[null, self::NAME, self::LANGUAGE, self::PSSWD],
			[null, self::NAME, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[null, self::NAME, self::LANGUAGE, null, null, self::IDENTIFIER],

			[null, self::NAME, null, self::PSSWD, self::LINKEDIN_PROFILE],
			[null, self::NAME, null, self::PSSWD, null, self::IDENTIFIER],

			[null, self::NAME, null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[null, null, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[null, null, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],

			[null, null, null, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::EMAIL, self::NAME, self::LANGUAGE, self::PSSWD],
			[self::EMAIL, self::NAME, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::NAME, self::LANGUAGE, null, null, self::IDENTIFIER],

			[null, self::NAME, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[null, self::NAME, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],

			[null, null, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::EMAIL, self::NAME, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::NAME, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],

			[null, self::NAME, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::EMAIL, self::NAME, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER]];
	}
}
