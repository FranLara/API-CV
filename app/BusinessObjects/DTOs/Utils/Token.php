<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs\Utils;

class Token
{
	public const string GUEST_ROLE = 'guest';
	public const string ADMIN_ROLE = 'admin';
	public const string RECRUITER_ROLE = 'recruiter';

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