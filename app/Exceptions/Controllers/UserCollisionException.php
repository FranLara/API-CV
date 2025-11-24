<?php

declare(strict_types=1);

namespace App\Exceptions\Controllers;

use App\Exceptions\Services\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserCollisionException extends HttpException
{
    public function __construct(private readonly Exception $exception)
    {
        parent::__construct($exception->getCode(), 'There is a collision with the given username.');
    }

    public function context(): array
    {
        return ['message' => $this->exception->getMessage(), 'username' => $this->exception->context()];
    }
}
