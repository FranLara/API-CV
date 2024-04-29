<?php
declare(strict_types = 1);

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Utils\Token;
use App\Http\Controllers\API\API as APIController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use function collect;

class Tokener
{
	private const ROLE_CLAIM = 'role';
	private const ROLES = [Token::ADMIN_ROLE, Token::RECRUITER_ROLE];

	//, 'technician'];
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
			// Throw exception of collision
		}

		Log::channel('credentials')->notice('The username "{username}" tried to request a token, but it could\'t login.', [
			'username' => $credentials['username']]);
		return $this->getPayload(new Token());
	}

	private function getPayload(Token $token): string
	{
		$claims = ['sub' => 0, self::ROLE_CLAIM => Token::GUEST_ROLE];
		$credentials = [APIController::USERNAME_PARAMETER => env('SUPER_ADMIN_USERNAME'),
			APIController::PSSWD_PARAMETER => env('SUPER_ADMIN_PASSWORD')];

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

		return ['email' => $token->getCredentials()[APIController::USERNAME_PARAMETER],
			'password' => $token->getCredentials()[APIController::PSSWD_PARAMETER]];
	}
}
