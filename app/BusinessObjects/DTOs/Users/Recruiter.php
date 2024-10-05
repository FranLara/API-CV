<?php

declare(strict_types=1);

namespace App\BusinessObjects\DTOs\Users;

use App\Utils\Abilities\Emailable;
use App\Utils\Abilities\LinkedinProfileable;
use App\Utils\Abilities\Nameable;

class Recruiter extends User
{
    use Emailable, Nameable, LinkedinProfileable;

    public function __construct(
        string $name = null,
        string $email = null,
        string $psswd = null,
        string $language = null,
        string $identifier = null,
        string $linkedinProfile = null
    ) {
        parent::__construct($identifier, $psswd, $language);

        $this->name = $name;
        $this->email = $email;
        $this->linkedinProfile = $linkedinProfile;
    }
}

