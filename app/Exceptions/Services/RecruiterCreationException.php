<?php
declare(strict_types = 1);

namespace App\Exceptions\Services;

use App\BusinessObjects\DTOs\Users\Recruiter;
use Dingo\Api\Http\Response;

class RecruiterCreationException extends Exception
{
	private Recruiter $recruiter;

	public function __construct(Recruiter $recruiter)
	{
		$errorMessage = sprintf('The recruiter with email %s was not created.', $recruiter->getEmail());
		parent::__construct($errorMessage, Response::HTTP_BAD_REQUEST);
		$this->recruiter = $recruiter;
	}

	public function context(): array
	{
		return ['recruiter' => $this->recruiter->toPayload()->toArray()];
	}
}

