<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API;

class Tokener
{
	private const ROLE_CLAIM = 'role';
	private const AUTH_GUARD = 'api.';

	public function getToken(array $credentials): string
	{
		$token = $this->getPayload(new Token('admin', $credentials));

		if (!empty($token)) {
			return $token;
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
