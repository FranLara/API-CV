<?php
namespace App\DTOs\Users;

abstract class User
{
    protected ?string $psswd;
    protected ?int $identifier;
    protected ?string $language;

    public function __construct(?int $identifier = null, ?string $psswd = null, ?string $language = null)
    {
        $this->psswd = $psswd;
        $this->language = $language;
        $this->identifier = $identifier;
    }

    public function getPsswd(): ?string
    {
        return $this->psswd;
    }

    public function setPsswd(?string $psswd): void
    {
        $this->psswd = $psswd;
    }
    
    public function getIdentifier(): ?int
    {
        return $this->identifier;
    }
    
    public function setIdentifier(?int $identifier): void
    {
        $this->identifier = $identifier;
    }
}

