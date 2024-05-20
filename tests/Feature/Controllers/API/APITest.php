<?php
declare(strict_types = 1);

namespace Tests\Feature\Controllers\API;

use Tests\Feature\FeatureTest;

abstract class APITest extends FeatureTest
{
	protected const API_TRANSLATIONS = 'api.';
	protected string $domain;

	protected function setUp(): void
	{
		parent::setUp();

		$this->domain = env('API_DOMAIN');
	}

	protected function getHeader(): array
	{
		$acceptHeader = env('API_STANDARDS_TREE') . '.' . env('API_SUBTYPE') . '.' . env('API_VERSION');

		return ['Accept' => 'application/' . $acceptHeader . '+json',
			'Authorization' => 'Bearer eyJpc3MiOiJodHRwczovL2RvbWFpbi50ZXN0L3Rva2VuIiwiaWF0IjoxNzE2MTk5MzgyLCJleHAiOjE3MTYyMDI5ODIsIm5iZiI6MTcxNjE5OTM4MiwianRpIjoib0Y4a2FDYUlvVFBndDJLTyIsInN1YiI6IjljMTY2MTc0LWZkNWYtNGMwYi1hYTIxLTdiMjFkNTIxZmJiNCIsInBydiI6IjUxNzNmZTRmMjM1MTc2NDk3M2JiNmVmMDRlMmUxMGFkYTA0YTVhMGUiLCJyb2xlIjoiYWRtaW4ifQ'];
	}
}
