<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\BusinessObjects\DTOs\DTO;
use App\Services\Saver as SaverInterface;

readonly abstract class Saver implements SaverInterface
{
    abstract public function save(DTO $user): bool;
}
