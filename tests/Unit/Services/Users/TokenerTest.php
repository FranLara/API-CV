<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Tests\Unit\Services\ServiceTests;

class TokenerTest extends ServiceTests
{
	private const array ROLE_CREATION = [Token::RECRUITER_ROLE];

	/**
	 * @dataProvider providerCredentials
	 */
	public function testGetToken(array $credentials = [], string $expectedRole = Token::GUEST_ROLE): void
	{
		if (in_array($expectedRole, self::ROLE_CREATION)) {
			$this->createUser($credentials, $expectedRole);
		}

		$token = (new Tokener())->getToken($credentials);
		$payload = app('tymon.jwt')->setToken($token)->getPayload();

		$this->assertSame($expectedRole, $payload->get('role'));
	}

	public static function providerCredentials(): array
	{
		return [[],
			[[APIController::USERNAME_PARAMETER => 'test_username', APIController::PSSWD_PARAMETER => 'test_psswd']],
			[
				[APIController::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
					APIController::PSSWD_PARAMETER => env('SUPER_ADMIN_PASSWORD')], Token::ADMIN_ROLE],
			[
				[APIController::USERNAME_PARAMETER => 'test@recruiter.com',
					APIController::PSSWD_PARAMETER => 'test_recruiter_password'], Token::RECRUITER_ROLE]];
	}

	private function createUser(array $credentials, string $expectedRole): void
	{
		$user = ['email' => $credentials[APIController::USERNAME_PARAMETER],
			'password' => Hash::make($credentials[APIController::PSSWD_PARAMETER])];
		if (Str::of($expectedRole)->exactly(Token::RECRUITER_ROLE)) {
			Recruiter::factory()->create($user);
		}
	}
}
