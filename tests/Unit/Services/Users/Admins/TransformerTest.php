<?php

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Admins\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
	private const IDENTIFIER = 31;
	private const USERNAME = 'test_username';
	private const LANGUAGE = 'test_language';

	/**
	 * @dataProvider providerAdminData
	 */
	public function testTransform(?string $username, ?string $language, ?int $identifier): void
	{
		$admin = (new Transformer())->transform($this->getModel($username, $language, $identifier));

		$this->assertSame($username, $admin->getUsername());
		$this->assertSame($language, $admin->getLanguage());
		$this->assertEquals($identifier, $admin->getIdentifier());
	}

	public static function providerAdminData(): array
	{
		return [[null, null, null], [self::USERNAME, null, null], [null, self::LANGUAGE, null],
			[null, null, self::IDENTIFIER], [self::USERNAME, null, self::IDENTIFIER],
			[null, self::LANGUAGE, self::IDENTIFIER], [self::USERNAME, self::LANGUAGE, self::IDENTIFIER],];
	}

	private function getModel(?string $username, ?string $language, ?int $identifier): AdminModel
	{
		$model = new AdminModel();
		$model->id = $identifier;
		$model->username = $username;
		$model->language = $language;

		return $model;
	}
}
