<?php
declare(strict_types = 1);

namespace Tests\Feature\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\Feature\Controllers\API\APITest;

class UserTest extends APITest
{
	private const TYPE_INDEX = 'token_type';
	private const TOKEN_INDEX = 'access_token';
	private const EXPIRATION_INDEX = 'expires_in';

	/**
	 * @dataProvider providerCredentials
	 */
	public function testRequest(array $credentials = [], int $expectedStatusCode = Response::HTTP_OK, string $expectedRole = Token::GUEST_ROLE): void
	{
		$response = $this->post($this->domain . '/account', $credentials, $this->header);
		$this->assertEquals($expectedStatusCode, $response->getStatusCode());

		if ($response->getStatusCode() == Response::HTTP_OK) {
			$token = json_decode($response->getContent())->{self::TOKEN_INDEX};
			$payload = app('tymon.jwt')->setToken($token)->getPayload();

			$this->assertSame($expectedRole, $payload->get('role'));
			$response->assertJson(fn (AssertableJson $json) => $json->hasAll([self::TYPE_INDEX, self::TOKEN_INDEX,
				self::EXPIRATION_INDEX])
				->where(self::TYPE_INDEX, 'bearer')
				->where(self::EXPIRATION_INDEX, 3600));
		}
	}

	public static function providerCredentials(): array
	{
		return [[], [[APIController::PSSWD_PARAMETER => 'test_psswd'], Response::HTTP_UNPROCESSABLE_ENTITY],
			[[APIController::USERNAME_PARAMETER => 'test_username'], Response::HTTP_UNPROCESSABLE_ENTITY],
			[[APIController::USERNAME_PARAMETER => 'test_username', APIController::PSSWD_PARAMETER => 'test_psswd']],
			[
				[APIController::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
					APIController::PSSWD_PARAMETER => env('SUPER_ADMIN_PASSWORD')], Response::HTTP_OK, 'admin']];
	}
}
