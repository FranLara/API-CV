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
	private const NAME = 'test_name';
	private const PSSWD = 'test_psswd';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';
	private const LINKEDIN_PROFILE = 'test_linkedin_profile';

	/**
	 * @dataProvider providerRecruiterData
	 */
	public function testMap(?string $name = null, ?string $language = null, ?string $psswd = null, ?string $linkedinProfile = null, ?string $identifier = null): void
	{
		$recruiter = (new Mapper())->map(new RecruiterDTO(null, $name, $language, $psswd, $linkedinProfile, $identifier), new Recruiter());

		$this->assertSame($name, $recruiter->name);
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
		return [[], [self::NAME], [null, self::LANGUAGE], [null, null, self::PSSWD],
			[null, null, null, self::LINKEDIN_PROFILE], [null, null, null, null, self::IDENTIFIER],

			[self::NAME, self::LANGUAGE], [self::NAME, null, self::PSSWD],
			[self::NAME, null, null, self::LINKEDIN_PROFILE], [self::NAME, null, null, null, self::IDENTIFIER],

			[null, self::LANGUAGE, self::PSSWD], [null, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[null, self::LANGUAGE, null, null, self::IDENTIFIER],
			[null, null, self::PSSWD, self::LINKEDIN_PROFILE], [null, null, self::PSSWD, null, self::IDENTIFIER],

			[null, null, null, self::LINKEDIN_PROFILE, self::IDENTIFIER],
			[self::NAME, self::LANGUAGE, self::PSSWD], [self::NAME, self::LANGUAGE, null, self::LINKEDIN_PROFILE],
			[self::NAME, self::LANGUAGE, null, null, self::IDENTIFIER],

			[null, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[null, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],

			[null, null, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::NAME, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE],
			[self::NAME, self::LANGUAGE, self::PSSWD, null, self::IDENTIFIER],

			[null, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER],

			[self::NAME, self::LANGUAGE, self::PSSWD, self::LINKEDIN_PROFILE, self::IDENTIFIER]];
	}
}
