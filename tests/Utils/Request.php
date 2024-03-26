<?php
declare(strict_types = 1);

namespace Tests\Utils;

use Illuminate\Http\Request as LaravelRequest;
use Mockery;

trait Request
{

	public function getRequest(): LaravelRequest
	{
		$mockedFunctions = ['validate' => true, 'only' => [], 'getSchemeAndHttpHost' => 'https://domain.test'];

		return Mockery::mock(LaravelRequest::class, $mockedFunctions);
	}
}

