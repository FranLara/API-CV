<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\Models\Users\User;
use App\Services\Mapper as MapperInterface;
use Illuminate\Database\Eloquent\Model;

readonly abstract class Mapper implements MapperInterface
{
    abstract public function map(DTO $dto, Model $user): User;
}
