<?php

declare(strict_types=1);

namespace Tests\Utils;

use Illuminate\Http\Request as LaravelRequest;
use Mockery;

trait Request
{
    protected function getRequest(array $additionalFunctions = []): LaravelRequest
    {
        $mockedFunctions = array_merge([
            'get'                  => '',
            'only'                 => [],
            'validate'             => true,
            'getSchemeAndHttpHost' => 'https://domain.test',
        ], $additionalFunctions);

        return Mockery::mock(LaravelRequest::class, $mockedFunctions);
    }
}

