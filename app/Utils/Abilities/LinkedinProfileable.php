<?php
declare(strict_types = 1);

namespace App\Utils\Abilities;

trait LinkedinProfileable
{
	protected ?string $linkedinProfile;

	public function getLinkedinProfile(): ?string
	{
		return $this->linkedinProfile;
	}

	public function setLinkedinProfilel(?string $linkedinProfile): void
	{
		$this->linkedinProfile = $linkedinProfile;
	}
}
