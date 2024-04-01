<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs\Users;

use App\Utils\Abilities\Emailable;
use App\Utils\Abilities\LinkedinProfileable;

class Recruiter extends User
{
	use Emailable, LinkedinProfileable;

	public function __construct(string $email = null, string $language = null, string $psswd = null, string $linkedinProfile = null, string $identifier = null)
	{
		parent::__construct($identifier, $psswd, $language);

		$this->email = $email;
		$this->linkedinProfile = $linkedinProfile;
	}
}

