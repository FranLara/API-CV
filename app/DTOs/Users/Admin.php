<?php
namespace app\DTOs\Users;

class Admin extends User
{

    private ?string $username;

    public function __construct(string $username = null, string $psswd = null, string $language = null)
    {
        parent::__construct($psswd = null, $language = null);
    }
}

