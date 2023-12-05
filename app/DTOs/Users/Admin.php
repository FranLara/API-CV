<?php
namespace App\DTOs\Users;

class Admin extends User
{
    private ?string $username;

    public function __construct(int $identifier = null, string $username = null, string $psswd = null, string $language = null)
    {
        parent::__construct($identifier, $psswd, $language);
        
        $this->username = $username;
    }
}

