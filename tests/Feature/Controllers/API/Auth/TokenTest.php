<?php
declare(strict_types = 1);

namespace Tests\Feature\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API as APIController;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\API\APITest;

class TokenTest extends APITest
{
	private const TYPE_INDEX = 'token_type';
	private const TOKEN_INDEX = 'access_token';
	private const EXPIRATION_INDEX = 'expires_in';

	/**
	 * @dataProvider providerCredentials
	 */
	public function testRequest(array $credentials = [], int $expectedSub = 0, string $expectedRole = Token::GUEST_ROLE): void
	{
		$response = $this->postJson($this->domain . '/token', $credentials, $this->header);
		$token = json_decode($response->getContent())->{self::TOKEN_INDEX};
		$payload = app('tymon.jwt')->setToken($token)->getPayload();

		$this->assertEquals($expectedSub, $payload->get('sub'));
		$this->assertSame($expectedRole, $payload->get('role'));
		$response->assertJson(fn (AssertableJson $json) => $json->hasAll([self::TYPE_INDEX, self::TOKEN_INDEX,
			self::EXPIRATION_INDEX])
			->where(self::TYPE_INDEX, 'bearer')
			->where(self::EXPIRATION_INDEX, 3600));
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
