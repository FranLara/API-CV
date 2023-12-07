<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\DTO;
use App\Services\Saver as SaverInterface;

abstract class Saver implements SaverInterface
{
    protected Mapper $mapper;

    abstract public function save(DTO $user);
}

