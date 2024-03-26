<?php
declare(strict_types = 1);

namespace Tests\Feature\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API as APIController;
use Tests\Feature\FeatureTest;

class TokenTest extends FeatureTest
{
	private const TYPE_INDEX = 'token_type';
	private const TOKEN_INDEX = 'access_token';
	private const EXPIRATION_INDEX = 'expires_in';

	/**
	 * @dataProvider providerCredentials
	 */
	public function testRequest(array $credentials = [], int $expectedSub = 0, string $expectedRole = Token::GUEST_ROLE): void
	{
		$payload = json_decode($this->post(env('API_DOMAIN') . '/token', $credentials, [
			'Accept' => 'application/x.franlara.v1+json'])->getContent(), true);

		$token = app('tymon.jwt')->setToken($payload[self::TOKEN_INDEX])->getPayload();

		$this->assertIsArray($payload);
		$this->assertArrayHasKey(self::TYPE_INDEX, $payload);
		$this->assertArrayHasKey(self::TOKEN_INDEX, $payload);
		$this->assertEquals($expectedSub, $token->get('sub'));
		$this->assertSame($expectedRole, $token->get('role'));
		$this->assertSame('bearer', $payload[self::TYPE_INDEX]);
		$this->assertArrayHasKey(self::EXPIRATION_INDEX, $payload);
		$this->assertEquals(3600, $payload[self::EXPIRATION_INDEX]);
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
