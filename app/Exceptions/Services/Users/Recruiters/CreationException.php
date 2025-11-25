<?php

declare(strict_types=1);

namespace App\Exceptions\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Services\Exception;
use Dingo\Api\Http\Response;

class CreationException extends Exception
{
    public function __construct(private readonly Recruiter $recruiter)
    {
        $errorMessage = sprintf('The recruiter with email %s was not created.', $recruiter->getEmail());
        parent::__construct($errorMessage, Response::HTTP_BAD_REQUEST);
    }

    public function context(): array
    {
        return ['recruiter' => $this->recruiter->toPayload()->toArray()];
    }
}
