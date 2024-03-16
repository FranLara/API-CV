<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API;

class Tokener
{
	private const ROLE_CLAIM = 'role';
	private const ROLES = ['admin'];

	//, 'recruiter', 'technician'];
	public function getToken(array $credentials): string
	{
		if (empty($credentials)) {
			return $this->getPayload(new Token());
		}

		return $this->getTokenByRole($credentials);
	}

	private function getTokenByRole(array $credentials): string
	{
		$token = collect(self::ROLES)->map(function (string $role) use ($credentials) {
			return $this->getPayload(new Token($role, $credentials));
		})
			->filter();

		if ($token->count() == 1) {
			return $token->first();
		}

		if ($token->count() > 1) {
			// Send notification of collision
		}

		return $this->getPayload(new Token());
	}

	private function getPayload(Token $token): string
	{
		$claims = ['sub' => 0, self::ROLE_CLAIM => Token::GUEST_ROLE];
		$credentials = [API::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
			API::PSSWD_PARAMETER => env('SUPER_ADMIN_PASSWORD')];

		if (!empty($token->getCredentials())) {
			$credentials = $token->getCredentials();
			$claims = [self::ROLE_CLAIM => $token->getRole()];
		}

		return auth('api.' . $token->getRole())->claims($claims)->attempt($credentials);
	}
}
