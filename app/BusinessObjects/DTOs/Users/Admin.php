<?php

namespace App\BusinessObjects\DTOs\Users;

class Admin extends User
{
    private ?string $username;

    public function __construct(int $identifier = null, string $username = null, string $psswd = null, string $language = null)
    {
        parent::__construct($identifier, $psswd, $language);

        $this->username = $username;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }
}

