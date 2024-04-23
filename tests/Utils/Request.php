<?php

declare(strict_types=1);

namespace Tests\Utils;

use Illuminate\Http\Request as LaravelRequest;
use Mockery;

trait Request
{
    protected function getRequest(): LaravelRequest
    {
        $mockedFunctions = [
            'get'                  => '',
            'only'                 => [],
            'validate'             => true,
            'getSchemeAndHttpHost' => 'https://domain.test',
        ];

        return Mockery::mock(LaravelRequest::class, $mockedFunctions);
    }
}

