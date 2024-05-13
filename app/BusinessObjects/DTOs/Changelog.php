<?php
declare(strict_types = 1);

namespace App\BusinessObjects\DTOs;

class Changelog extends DTO
{
    public function __construct(private string $entityId, private string $type, private string $valuePayload)
    {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getEntityId(): string
    {
        return $this->entityId;
    }

    public function getValuePayload(): string
    {
        return $this->valuePayload;
    }
}