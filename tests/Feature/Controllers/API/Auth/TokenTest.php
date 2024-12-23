<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Utils\Token;
use App\BusinessObjects\Models\Users\Admin;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use Tests\Feature\Controllers\API\APITests;

class TokenTest extends APITests
{
    private const string PSSWD = 'test_psswd';
    private const string TYPE_INDEX = 'token_type';
    private const string TOKEN_INDEX = 'access_token';
    private const string EXPIRATION_INDEX = 'expires_in';

    /**
     * @dataProvider providerCredentials
     */
    public function testRequest(
        array $credentials = [],
        int $expectedStatusCode = Response::HTTP_OK,
        string $expectedRole = Token::GUEST_ROLE
    ): void {
        if (empty($credentials)) {
            $credentials = $this->getCredentials($expectedRole);
        }

        $response = $this->getTokenResponse($credentials);
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $token = json_decode($response->getContent())->{self::TOKEN_INDEX};
            $payload = app('tymon.jwt')->setToken($token)->getPayload();

            $this->assertSame($expectedRole, $payload->get('role'));
            $response->assertJson(fn(AssertableJson $json) => $json->hasAll([
                self::TYPE_INDEX,
                self::TOKEN_INDEX,
                self::EXPIRATION_INDEX
            ])->where(self::TYPE_INDEX, 'bearer')->where(self::EXPIRATION_INDEX, 3600));
        }
    }

    /**
     * @dataProvider providerRole
     */
    public function testRefresh(int $expectedStatusCode = Response::HTTP_UNAUTHORIZED, string $role = null): void
    {
        $authorization = ['Authorization' => 'Bearer ' . $this->getToken($role)];
        $response = $this->getJson($this->domain . '/tokens', $this->getHeader($authorization));
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $response->assertJson(fn(AssertableJson $json) => $json->hasAll([
                self::TYPE_INDEX,
                self::TOKEN_INDEX,
                self::EXPIRATION_INDEX
            ])->where(self::TYPE_INDEX, 'bearer')->where(self::EXPIRATION_INDEX, 1860));
        }
    }

    public static function providerCredentials(): array
    {
        return [
            [],
            [[], Response::HTTP_OK, Token::ADMIN_ROLE],
            [[], Response::HTTP_OK, Token::RECRUITER_ROLE],
            [[APIController::PSSWD_PARAMETER => self::PSSWD], Response::HTTP_UNPROCESSABLE_ENTITY],
            [[APIController::USERNAME_PARAMETER => 'test_username'], Response::HTTP_UNPROCESSABLE_ENTITY],
            [[APIController::USERNAME_PARAMETER => 'test_username', APIController::PSSWD_PARAMETER => self::PSSWD]],
        ];
    }

    public static function providerRole(): array
    {
        return [
            [],
            [Response::HTTP_OK, Token::GUEST_ROLE],
            [Response::HTTP_OK, Token::ADMIN_ROLE],
            [Response::HTTP_OK, Token::RECRUITER_ROLE],
        ];
    }

    private function getCredentials(string $role = Token::GUEST_ROLE): array
    {
        return match ($role) {
            Token::GUEST_ROLE => [],
            Token::ADMIN_ROLE => $this->getAdminCredentials(),
            Token::RECRUITER_ROLE => $this->getRecruiterCredentials(),
        };
    }

    private function getTokenResponse(array $credentials): TestResponse
    {
        return $this->postJson($this->domain . '/tokens', $credentials, $this->getHeader());
    }

    private function getToken(?string $role): string
    {
        if (empty($role)) {
            return 'test_token';
        }

        return json_decode($this->getTokenResponse($this->getCredentials($role))->getContent())->{self::TOKEN_INDEX};
    }

    private function getAdminCredentials(): array
    {
        $admin = Admin::factory()->create(['password' => Hash::make(self::PSSWD)]);

        return $this->getCredential($admin->username);
    }

    private function getCredential(string $username): array
    {
        return [APIController::USERNAME_PARAMETER => $username, APIController::PSSWD_PARAMETER => self::PSSWD];
    }

    private function getRecruiterCredentials(): array
    {
        $recruiter = Recruiter::factory()->create(['password' => Hash::make(self::PSSWD)]);

        return $this->getCredential($recruiter->email);
    }
}
