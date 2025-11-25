<?php

declare(strict_types=1);

namespace App\Exceptions\Services\Users;

use App\BusinessObjects\DTOs\Users\User;
use App\Exceptions\Services\Exception;
use Dingo\Api\Http\Response;

class UserNotFoundException extends Exception
{
    public function __construct(private readonly User $user, private readonly string $field)
    {
        $errorMessage = sprintf('The user type %s was not found by its field %s.', get_class($user), $field);
        parent::__construct($errorMessage, Response::HTTP_BAD_REQUEST);
    }

    public function context(): array
    {
        return ['field' => $this->field, 'user' => $this->user->toPayload()->toArray()];
    }
}
