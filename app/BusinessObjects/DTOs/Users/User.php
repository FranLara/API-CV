<?php

declare(strict_types=1);

namespace App\BusinessObjects\DTOs\Users;

use App\BusinessObjects\DTOs\DTO;

abstract class User extends DTO
{
    public function __construct(protected ?string $identifier, protected ?string $psswd, protected ?string $language)
    {
        parent::__construct($identifier);
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
