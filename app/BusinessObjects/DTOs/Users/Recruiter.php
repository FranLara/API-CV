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
        protected ?string $name = null,
        protected ?string $email = null,
        protected ?string $psswd = null,
        protected ?string $language = null,
        protected ?string $identifier = null,
        protected ?string $linkedinProfile = null
    ) {
        parent::__construct($identifier, $psswd, $language);
    }
}
