<?php

declare(strict_types=1);

namespace App\BusinessObjects\DTOs\Users;

class Admin extends User
{
    public function __construct(
        protected ?string $psswd = null,
        private ?string $username = null,
        protected ?string $language = null,
        protected ?string $identifier = null
    ) {
        parent::__construct($identifier, $psswd, $language);
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}
