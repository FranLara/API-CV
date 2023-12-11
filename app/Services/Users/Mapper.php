<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\DTO;
use App\Services\Mapper as MapperInterface;
use Illuminate\Database\Eloquent\Model;

abstract class Mapper implements MapperInterface
{

    abstract public function map(DTO $dto, Model $user): Model;
}

