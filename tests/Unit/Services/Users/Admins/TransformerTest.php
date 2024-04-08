<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Admins\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
	private const USERNAME = 'test_username';
	private const LANGUAGE = 'test_language';
	private const IDENTIFIER = 'test_identifier';

	/**
	 * @dataProvider providerAdminData
	 */
	public function testTransform(?string $username = null, ?string $language = null, ?string $identifier = null): void
	{
		$admin = (new Transformer())->transform($this->getModel($username, $language, $identifier));

		$this->assertSame($username, $admin->getUsername());
		$this->assertSame($language, $admin->getLanguage());
		$this->assertSame($identifier, $admin->getIdentifier());
	}

	public static function providerAdminData(): array
	{
		return [[], [self::USERNAME], [null, self::LANGUAGE], [null, null, self::IDENTIFIER],
			[self::USERNAME, self::LANGUAGE], [self::USERNAME, null, self::IDENTIFIER],
			[null, self::LANGUAGE, self::IDENTIFIER], [self::USERNAME, self::LANGUAGE, self::IDENTIFIER],];
	}

	private function getModel(?string $username, ?string $language, ?string $identifier): AdminModel
	{
		$model = new AdminModel();
		$model->id = $identifier;
		$model->username = $username;
		$model->language = $language;

		return $model;
	}
}
