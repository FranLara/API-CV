<?php

declare(strict_types=1);

namespace App\Exceptions\Services;

use Dingo\Api\Http\Response;

class TokenUserCollisionException extends Exception
{
    public function __construct(private readonly string $username)
    {
        $errorMessage = sprintf('User collision for the username %s generating a JWT.', $this->username);
        parent::__construct($errorMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function context(): array
    {
        return ['username' => $this->username];
    }
}
