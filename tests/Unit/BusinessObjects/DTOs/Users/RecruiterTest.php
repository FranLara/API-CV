<?php
declare(strict_types = 1);

namespace Tests\Unit\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\Users\Recruiter;
use PHPUnit\Framework\TestCase;

class RecruiterTest extends TestCase
{
	private const EMAIL = 'test_email';
	private const PSSWD = 'test_psswd';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';
	private const LINKEDIN_PROFILE = 'test_linkedin_profile';

	/**
	 * @dataProvider providerConstructorData
	 */
	public function testConstructor(?string $email = null, ?string $language = null, ?string $psswd = null, ?string $linkedinProfile = null, ?string $identifier = null): void
	{
		$recruiter = new Recruiter($email, $language, $psswd, $linkedinProfile, $identifier);

		$this->assertSame($email, $recruiter->getEmail());
		$this->assertSame($psswd, $recruiter->getPsswd());
		$this->assertSame($language, $recruiter->getLanguage());
		$this->assertSame($identifier, $recruiter->getIdentifier());
		$this->assertSame($linkedinProfile, $recruiter->getLinkedinProfile());
	}

	public static function providerConstructorData(): array
	{
		return [[], [self::EMAIL], [null, self::LANGUAGE], [null, null, self::PSSWD],
			[null, null, null, self::LINKEDIN_PROFILE], [null, null, null, null, self::IDENTIFIER],
			[self::EMAIL, self::LANGUAGE], [self::EMAIL, null, self::PSSWD],
			[self::EMAIL, null, null, self::LINKEDIN_PROFILE], [null, self::LANGUAGE, self::PSSWD],
			[null, self::LANGUAGE, null, self::LINKEDIN_PROFILE], [null, self::LANGUAGE, null, null, self::IDENTIFIER],
			[null, null, self::PSSWD, self::LINKEDIN_PROFILE], [null, null, self::PSSWD, null, self::IDENTIFIER],
			[null, null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER], [self::EMAIL, self::LANGUAGE, self::PSSWD],
			[self::EMAIL, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::LANGUAGE, null, null, self::IDENTIFIER],
			[null, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[null, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],
			[null, null, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::EMAIL, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[self::EMAIL, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],
			[null, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::EMAIL, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER]];
	}
}
