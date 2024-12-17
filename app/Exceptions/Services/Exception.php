<?php

declare(strict_types=1);

namespace App\Exceptions\Services;

use Exception as BaseException;

abstract class Exception extends BaseException
{
    abstract public function context(): array;
}
