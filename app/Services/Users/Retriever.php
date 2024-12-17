<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Users\User;
use App\Services\Retriever as RetrieverInterface;

readonly abstract class Retriever implements RetrieverInterface
{
    abstract public function retrieve(string $identifier): User;

    abstract public function retrieveByField(string $field, $value): User;
}

