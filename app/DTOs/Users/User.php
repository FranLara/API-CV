<?php
namespace app\DTOs\Users;

abstract class User
{
    private ?string $psswd;
    private ?string $language;

    public function __construct(string $psswd = null, string $language = null)
    {
        $this->psswd = $psswd;
        $this->language = $language;
    }
}

