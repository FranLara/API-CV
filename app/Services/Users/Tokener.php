<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Exceptions\Services\TokenUserCollisionException;
use App\Http\Controllers\API\API as APIController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function collect;

class Tokener
{
    private const string ROLE_CLAIM = 'role';
    private const array ROLES = [Token::ADMIN_ROLE, Token::RECRUITER_ROLE, Token::TECHNICIAN_ROLE];

    /**
     * @throws TokenUserCollisionException
     */
    public function getToken(array $credentials): string
    {
        if (empty($credentials)) {
            return $this->getPayload(new Token());
        }

        return $this->getTokenByRole($credentials);
    }

    /**
     * @throws TokenUserCollisionException
     */
    private function getTokenByRole(array $credentials): string
    {
        $token = collect(self::ROLES)->map(
            function (string $role) use ($credentials) {
                return $this->getPayload(new Token($role, $credentials));
            }
        )->filter();

        if ($token->count() === 1) {
            return $token->first();
        }

        if ($token->count() > 1) {
            throw new TokenUserCollisionException($credentials[APIController::USERNAME_PARAMETER]);
        }

        $message = 'The username "{username}" tried to request a token, but it could\'t login.';
        Log::channel('credentials')->notice($message, ['username' => $credentials[APIController::USERNAME_PARAMETER]]);

        return $this->getPayload(new Token());
    }

    private function getPayload(Token $token): string
    {
        $claims = ['sub' => 0, self::ROLE_CLAIM => Token::GUEST_ROLE];
        $credentials = [
            APIController::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
            APIController::PSSWD_PARAMETER    => env('SUPER_ADMIN_PASSWORD'),
        ];

        if (!empty($token->getCredentials())) {
            $credentials = $this->getCredentials($token);
            $claims = [self::ROLE_CLAIM => $token->getRole()];
        }

        $token = auth('api.' . $token->getRole())->claims($claims)->attempt($credentials);

        if (strval($token)) {
            return $token;
        }

        return '';
    }

    private function getCredentials(Token $token): array
    {
        if (Str::of($token->getRole())->exactly(Token::ADMIN_ROLE)) {
            return $token->getCredentials();
        }

        return [
            'password' => $token->getCredentials()[APIController::PSSWD_PARAMETER],
            'email'    => $token->getCredentials()[APIController::USERNAME_PARAMETER],
        ];
    }
}
