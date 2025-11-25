<?php

declare(strict_types=1);

namespace App\Exceptions\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Services\Exception;
use Dingo\Api\Http\Response;
use Illuminate\Support\Facades\DB;

class RecruiterPromotionException extends Exception
{
    public function __construct(private readonly Recruiter $recruiter)
    {
        DB::rollBack();

        $errorMessage = sprintf('The recruiter with email %s was not promoted.', $recruiter->getEmail());
        parent::__construct($errorMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function context(): array
    {
        return ['recruiter' => $this->recruiter->toPayload()->toArray()];
    }
}
