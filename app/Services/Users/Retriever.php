<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Users\User;
use App\Services\Retriever as RetrieverInterface;

abstract class Retriever implements RetrieverInterface
{
	protected Transformer $transformer;

	abstract public function retrieve(int $identifier): User;

	abstract public function retrieveByField(string $field, $value): User;
}

