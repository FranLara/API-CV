<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\BusinessObjects\Models\Users\Recruiter;
use App\BusinessObjects\Models\Users\Technician;
use App\Exceptions\Services\TokenUserCollisionException;
use App\Http\Controllers\API\API as APIController;
use App\Services\Users\Tokener;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\Services\ServiceTests;

class TokenerTest extends ServiceTests
{
    private const array ROLE_CREATION = [Token::RECRUITER_ROLE, Token::TECHNICIAN_ROLE];

    /**
     * @throws TokenUserCollisionException
     */
    #[DataProvider('providerCredentials')]
    public function testGetToken(array $credentials, string $expectedRole = Token::GUEST_ROLE): void
    {
        if (in_array($expectedRole, self::ROLE_CREATION)) {
            $this->createUser($credentials, $expectedRole);
        }

        $token = new Tokener()->getToken($credentials);
        $payload = app('tymon.jwt')->setToken($token)->getPayload();

        $this->assertSame($expectedRole, $payload->get('role'));
    }

    public function testGetTokenTokenUserCollisionException(): void
    {
        $this->expectException(TokenUserCollisionException::class);

        $credentials = [
            APIController::USERNAME_PARAMETER => 'test@collision.com',
            APIController::PSSWD_PARAMETER    => 'test_collision_password',
        ];
        $this->createUser($credentials, Token::RECRUITER_ROLE);
        $this->createUser($credentials, Token::TECHNICIAN_ROLE);


        new Tokener()->getToken($credentials);
    }

    public static function providerCredentials(): array
    {
        $admin = [
            [
                APIController::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
                APIController::PSSWD_PARAMETER    => env('SUPER_ADMIN_PASSWORD'),
            ],
            Token::ADMIN_ROLE,
        ];
        $recruiter = [
            [
                APIController::USERNAME_PARAMETER => 'test@recruiter.com',
                APIController::PSSWD_PARAMETER    => 'test_recruiter_password',
            ],
            Token::RECRUITER_ROLE,
        ];
        $technician = [
            [
                APIController::USERNAME_PARAMETER => 'test@technician.com',
                APIController::PSSWD_PARAMETER    => 'test_technician_password',
            ],
            Token::TECHNICIAN_ROLE,
        ];

        return [
            $admin,
            $recruiter,
            $technician,
            [[], Token::GUEST_ROLE],
            [[APIController::USERNAME_PARAMETER => 'test_username', APIController::PSSWD_PARAMETER => 'test_psswd']],
        ];
    }

    private function createUser(array $credentials, string $expectedRole): void
    {
        $user = [
            'email'    => $credentials[APIController::USERNAME_PARAMETER],
            'password' => Hash::make($credentials[APIController::PSSWD_PARAMETER]),
        ];
        if (Str::of($expectedRole)->exactly(Token::RECRUITER_ROLE)) {
            Recruiter::factory()->create($user);
        }
        if (Str::of($expectedRole)->exactly(Token::TECHNICIAN_ROLE)) {
            Technician::factory()->create($user);
        }
    }
}
