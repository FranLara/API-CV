<?php

namespace App\Services;

use App\BusinessObjects\DTOs\DTO;

interface Retriever
{

    public function retrieve(int $identifier): DTO;

    public function retrieveByField(string $field, $value): DTO;
}
