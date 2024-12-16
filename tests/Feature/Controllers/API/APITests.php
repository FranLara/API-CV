<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use Tests\Feature\FeatureTests;

abstract class APITests extends FeatureTests
{
    protected const string API_TRANSLATIONS = 'api.';
    protected string $domain;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domain = env('API_DOMAIN');
    }

    protected function getHeader(array $headers = []): array
    {
        $acceptHeader = env('API_STANDARDS_TREE') . '.' . env('API_SUBTYPE') . '.' . env('API_VERSION');

        return array_merge(['Accept' => 'application/' . $acceptHeader . '+json'], $headers);
    }
}
