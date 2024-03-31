<?php
declare(strict_types = 1);

namespace Tests\Unit\Http\Controllers\API;

use Tests\TestCase;
use Tests\Utils\Request as RequestUtils;

abstract class APITest extends TestCase
{
	use RequestUtils;
	protected const API_TRANSLATIONS = 'api.';
}
