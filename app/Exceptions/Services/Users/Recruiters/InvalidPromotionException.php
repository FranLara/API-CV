<?php

declare(strict_types=1);

namespace App\Exceptions\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Services\Exception;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\DB;

class InvalidPromotionException extends Exception
{
    public function __construct(private readonly Recruiter $recruiter)
    {
        parent::__construct('The recruiter is invalid to be promoted.', Response::HTTP_CONFLICT);
    }

    public function context(): array
    {
        return ['recruiter' => $this->recruiter->toPayload()->toArray()];
    }
}
