<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API;

use Tests\TestCase;
use Tests\Utils\Request as RequestUtils;

abstract class APITests extends TestCase
{
    use RequestUtils;

    protected const string API_TRANSLATIONS = 'api.';
}
