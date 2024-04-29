<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs\Utils;

class Token
{
	public const GUEST_ROLE = 'guest';
	public const ADMIN_ROLE = 'admin';
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
		return $this->credentials;
	}
}