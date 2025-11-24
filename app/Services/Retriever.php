<?php

declare(strict_types=1);

namespace App\Services;

use App\BusinessObjects\DTOs\DTO;

interface Retriever
{
    public function retrieve(string $identifier): DTO;

    public function retrieveByField(string $field, $value): DTO;
}
