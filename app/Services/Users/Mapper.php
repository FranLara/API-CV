<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Users\User as UserDTO;
use App\Services\Mapper as MapperInterface;
use App\BusinessObjects\Models\Users\User;

abstract class Mapper implements MapperInterface
{
    abstract public function map(UserDTO $dto, User $user);
}

