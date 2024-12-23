<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\DTO;

abstract class User extends DTO
{
	protected ?string $psswd;
	protected ?string $language;

	public function __construct(?string $identifier = null, ?string $psswd = null, ?string $language = null)
	{
		parent::__construct($identifier);

		$this->psswd = $psswd;
		$this->language = $language;
	}

	public function getPsswd(): ?string
	{
		return $this->psswd;
	}

	public function setPsswd(string $psswd): void
	{
		$this->psswd = $psswd;
	}

	public function getLanguage(): ?string
	{
		return $this->language;
	}

	public function setLanguage(string $language): void
	{
		$this->language = $language;
	}
}
