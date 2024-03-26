<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Admins\Mapper;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MapperTest extends TestCase
{
	private const IDENTIFIER = 31;
	private const PSSWD = 'test_psswd';
	private const LANGUAGE = 'test_language';

	/**
	 * @dataProvider providerAdminData
	 */
	public function testMap(?string $language, ?string $psswd, ?int $identifier): void
	{
		$admin = (new Mapper())->map(new AdminDTO(null, $language, $psswd, $identifier), new Admin());

		$this->assertSame($language, $admin->language);
		if (!empty($psswd)) {
			$this->assertTrue(Hash::check($psswd, $admin->password));
		}
		if (empty($identifier)) {
			$this->assertGreaterThan(now()->subMinute(), $admin->created_at);
		}
	}

	public static function providerAdminData(): array
	{
		return [[null, null, null], [null, self::PSSWD, null], [self::LANGUAGE, null, null],
			[null, null, self::IDENTIFIER], [null, self::PSSWD, self::IDENTIFIER],
			[self::LANGUAGE, null, self::IDENTIFIER], [self::LANGUAGE, self::PSSWD, self::IDENTIFIER]];
	}
}
