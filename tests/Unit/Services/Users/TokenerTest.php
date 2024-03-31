<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Tests\Unit\Services\ServiceTest;

class TokenerTest extends ServiceTest
{

	/**
	 * @dataProvider providerCredentials
	 */
	public function testGetToken(array $credentials = [], int $expectedSub = 0, string $expectedRole = Token::GUEST_ROLE): void
	{
		$token = (new Tokener())->getToken($credentials);
		$payload = app('tymon.jwt')->setToken($token)->getPayload();

		$this->assertEquals($expectedSub, $payload->get('sub'));
		$this->assertSame($expectedRole, $payload->get('role'));
	}

	public static function providerCredentials(): array
	{
		return [[],
			[[APIController::USERNAME_PARAMETER => 'test_username', APIController::PSSWD_PARAMETER => 'test_psswd']],
			[
				[APIController::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
					APIController::PSSWD_PARAMETER => env('SUPER_ADMIN_PASSWORD')], 1, 'admin']];
	}
}
