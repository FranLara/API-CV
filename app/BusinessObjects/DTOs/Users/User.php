<?php

namespace App\BusinessObjects\DTOs\Users;

use app\BusinessObjects\DTOs\DTO;

abstract class User extends DTO
{
    protected ?string $psswd;
    protected ?string $language;

    public function __construct(?int $identifier = null, ?string $psswd = null, ?string $language = null)
    {
        parent::__construct($identifier);

        $this->psswd = $psswd;
        $this->language = $language;
    }

    public function getPsswd(): ?string
    {
        return $this->psswd;
    }

    public function setPsswd(string $psswd): void
    {
        $this->psswd = $psswd;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }
}
