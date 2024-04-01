<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs;

abstract class DTO
{
	protected ?string $identifier;

	public function __construct(?string $identifier = null)
	{
		$this->identifier = $identifier;
	}

	public function getIdentifier(): ?string
	{
		return $this->identifier;
	}

	public function setIdentifier(string $identifier): void
	{
		$this->identifier = $identifier;
	}
}

