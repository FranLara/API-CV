<?php

namespace App\Services\Users;

use App\BusinessObjects\DTOs\Users\User;
use app\Services\Saver as SaverInterface;

abstract class Saver implements SaverInterface
{
    protected Mapper $mapper;
    
    abstract public function save(User $user);
}

