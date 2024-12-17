<?php

declare(strict_types=1);

namespace App\BusinessObjects\DTOs;

class Changelog extends DTO
{
    public function __construct(
        private readonly string $type,
        private readonly string $entityId,
        private readonly string $valuePayload
    ) {
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
