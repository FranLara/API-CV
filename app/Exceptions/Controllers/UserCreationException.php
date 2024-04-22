<?php
declare(strict_types = 1);

namespace App\Exceptions\Controllers;

use App\Exceptions\Services\Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserCreationException extends HttpException
{
	private Exception $exception;

	public function __construct(Exception $exception)
	{
		parent::__construct($exception->getCode(), 'The user was not created.');
		$this->exception = $exception;
	}

	public function context(): array
	{
		return ['message' => $this->exception->getMessage(), 'user' => $this->exception->context()];
	}
}

