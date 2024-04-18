<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs\Utils;

use App\Http\Controllers\API\API;
use Illuminate\Support\Str;

class Token
{
	public const GUEST_ROLE = 'guest';
	public const RECRUITER_ROLE = 'recruiter';
	private string $role;
	private array $credentials;

	public function __construct(string $role = self::GUEST_ROLE, array $credentials = [])
	{
		$this->role = $role;
		$this->credentials = $credentials;
	}

	public function getRole(): string
	{
		return $this->role;
	}

	public function getCredentials(): array
	{
		if (Str::of($this->role)->exactly(self::RECRUITER_ROLE)) {
			$this->credentials[API::EMAIL_PARAMETER] = $this->credentials[API::USERNAME_PARAMETER];
			unset($this->credentials[API::USERNAME_PARAMETER]);
		}

		return $this->credentials;
	}
}