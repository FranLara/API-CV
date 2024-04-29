<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use Tests\Feature\FeatureTest;

abstract class APITest extends FeatureTest
{
    protected const string API_TRANSLATIONS = 'api.';
    protected string $domain;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domain = env('API_DOMAIN');
    }

    protected function getHeader(): array
    {
        $acceptHeader = env('API_STANDARDS_TREE') . '.' . env('API_SUBTYPE') . '.' . env('API_VERSION');

        return ['Accept' => 'application/' . $acceptHeader . '+json'];
    }
}
