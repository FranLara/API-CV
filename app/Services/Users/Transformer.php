<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Users\User;
use App\Services\Transformer as TransformerInterface;
use Illuminate\Database\Eloquent\Model;

abstract class Transformer implements TransformerInterface
{

    abstract public function transform(Model $user): User;
}

