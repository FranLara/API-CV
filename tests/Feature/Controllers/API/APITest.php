<?php
declare(strict_types = 1);

namespace Tests\Feature\Controllers\API;

use Tests\Feature\FeatureTest;

abstract class APITest extends FeatureTest
{
	protected const API_TRANSLATIONS = 'api.';
	protected string $domain;
	protected array $header = ['Accept' => 'application/x.franlara.v1+json'];

	protected function setUp(): void
	{
		parent::setUp();

		$this->domain = env('API_DOMAIN');
	}
}
