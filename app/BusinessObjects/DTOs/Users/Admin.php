<?php

namespace App\BusinessObjects\DTOs\Users;

class Admin extends User
{
    private ?string $username;

    public function __construct(
        string $username = null,
        string $language = null,
        string $psswd = null,
        int $identifier = null
    ) {
        parent::__construct($identifier, $psswd, $language);

        $this->username = $username;
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

