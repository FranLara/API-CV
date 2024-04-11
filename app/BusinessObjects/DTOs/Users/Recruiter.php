<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs\Users;

use App\Utils\Abilities\Emailable;
use App\Utils\Abilities\LinkedinProfileable;
use App\Utils\Abilities\Nameable;

class Recruiter extends User
{
	use Emailable, Nameable, LinkedinProfileable;

	public function __construct(string $email = null, string $name = null, string $language = null, string $psswd = null, string $linkedinProfile = null, string $identifier = null)
	{
		parent::__construct($identifier, $psswd, $language);

		$this->name = $name;
		$this->email = $email;
		$this->linkedinProfile = $linkedinProfile;
	}
}

