<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Utils\Token;
use App\BusinessObjects\Models\Users\Admin;
use App\BusinessObjects\Models\Users\Recruiter;
use App\BusinessObjects\Models\Users\Technician;
use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\Controllers\API\APITests;

class TokenTest extends APITests
{
    private const string PSSWD = 'test_psswd';
    private const string TYPE_INDEX = 'token_type';
    private const string TOKEN_INDEX = 'access_token';
    private const string EXPIRATION_INDEX = 'expires_in';
    private const array INDEXES = [self::TYPE_INDEX, self::TOKEN_INDEX, self::EXPIRATION_INDEX];

    #[DataProvider('providerCredentials')]
    public function testRequest(
        string $expectedRole = Token::GUEST_ROLE,
        array $credentials = [],
        int $expectedStatusCode = Response::HTTP_OK
    ): void {
        if (empty($credentials)) {
            $credentials = $this->getCredentials($expectedRole);
        }
        if ((!Str::of($expectedRole)->exactly(Token::GUEST_ROLE)) && ($expectedStatusCode != Response::HTTP_OK)) {
            $this->getTechnicianCredentials($credentials[APIController::USERNAME_PARAMETER]);
        }

        $response = $this->getTokenResponse($credentials);
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $token = json_decode($response->getContent())->{self::TOKEN_INDEX};
            $payload = app('tymon.jwt')->setToken($token)->getPayload();

            $this->assertSame($expectedRole, $payload->get('role'));
            $response->assertJson(
                fn(AssertableJson $json) => $json->hasAll(self::INDEXES)->where(self::TYPE_INDEX, 'bearer')->where(
                    self::EXPIRATION_INDEX,
                    3600
                )
            );
        }
    }

    #[DataProvider('providerRole')]
    public function testRefresh(int $expectedStatusCode, ?string $role = null): void
    {
        $authorization = ['Authorization' => 'Bearer ' . $this->getToken($role)];
        $response = $this->getJson($this->domain . '/tokens', $this->getHeader($authorization));
        $this->assertEquals($expectedStatusCode, $response->getStatusCode());

        if ($response->getStatusCode() == Response::HTTP_OK) {
            $response->assertJson(
                fn(AssertableJson $json) => $json->hasAll(self::INDEXES)->where(self::TYPE_INDEX, 'bearer')->where(
                    self::EXPIRATION_INDEX,
                    1860
                )
            );
        }
    }

    public static function providerCredentials(): array
    {
        $psswd = [APIController::PSSWD_PARAMETER => self::PSSWD];
        $username = [APIController::USERNAME_PARAMETER => 'test_username'];

        return [
            [],
            [Token::ADMIN_ROLE],
            [Token::RECRUITER_ROLE],
            [Token::TECHNICIAN_ROLE],
            [Token::GUEST_ROLE, array_merge($username, $psswd)],
            [Token::GUEST_ROLE, $psswd, Response::HTTP_UNPROCESSABLE_ENTITY],
            [Token::RECRUITER_ROLE, [], Response::HTTP_INTERNAL_SERVER_ERROR],
            [Token::GUEST_ROLE, $username, Response::HTTP_UNPROCESSABLE_ENTITY],
        ];
    }

    public static function providerRole(): array
    {
        return [
            [Response::HTTP_UNAUTHORIZED],
            [Response::HTTP_OK, Token::GUEST_ROLE],
            [Response::HTTP_OK, Token::ADMIN_ROLE],
            [Response::HTTP_OK, Token::RECRUITER_ROLE],
            [Response::HTTP_OK, Token::TECHNICIAN_ROLE],
        ];
    }

    private function getCredentials(string $role = Token::GUEST_ROLE): array
    {
        return match ($role) {
            Token::ADMIN_ROLE => $this->getAdminCredentials(),
            Token::RECRUITER_ROLE => $this->getRecruiterCredentials(),
            Token::TECHNICIAN_ROLE => $this->getTechnicianCredentials(),
            default => [],
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

    private function getTechnicianCredentials(string $email = ''): array
    {
        $technician = ['password' => Hash::make(self::PSSWD)];

        if (!empty($email)) {
            $technician = array_merge(['email' => $email], $technician);
        }

        $technician = Technician::factory()->create($technician);

        return $this->getCredential($technician->email);
    }
}
