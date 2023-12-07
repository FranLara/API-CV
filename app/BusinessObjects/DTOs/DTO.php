<?php

namespace App\BusinessObjects\DTOs;

abstract class DTO
{
    protected ?int $identifier;

    public function __construct(?int $identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): ?int
    {
        return $this->identifier;
    }

    public function setIdentifier(int $identifier): void
    {
        $this->identifier = $identifier;
    }
}

