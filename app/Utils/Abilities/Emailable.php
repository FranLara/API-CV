<?php

declare(strict_types=1);

namespace App\Utils\Abilities;

trait Emailable
{
    protected ?string $email;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
