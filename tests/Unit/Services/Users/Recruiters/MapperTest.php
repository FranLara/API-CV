<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Recruiters\Mapper;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MapperTest extends TestCase
{
	private const PSSWD = 'test_psswd';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';
	private const LINKEDIN_PROFILE = 'test_linkedin_profile';

	/**
	 * @dataProvider providerRecruiterData
	 */
	public function testMap(?string $language = null, ?string $psswd = null, ?string $linkedinProfile = null, ?string $identifier = null): void
	{
		$recruiter = (new Mapper())->map(new RecruiterDTO(null, $language, $psswd, $linkedinProfile, $identifier), new Recruiter());

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
		return [[], [self::LANGUAGE], [null, self::PSSWD], [null, null, self::LINKEDIN_PROFILE],
			[null, null, null, self::IDENTIFIER], [self::LANGUAGE, self::PSSWD],
			[self::LANGUAGE, null, self::LINKEDIN_PROFILE], [self::LANGUAGE, null, null, self::IDENTIFIER],
			[null, self::PSSWD, self::LINKEDIN_PROFILE], [null, self::PSSWD, null, self::IDENTIFIER],
			[null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],
			[null, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER]];
	}
}
