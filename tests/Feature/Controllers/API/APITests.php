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

        $this->domain = config('api.domain');
    }

    protected function getHeader(array $headers = []): array
    {
        $acceptHeader = config('api.standardsTree') . '.' . config('api.subtype') . '.' . config('api.version');

        return array_merge(['Accept' => 'application/' . $acceptHeader . '+json'], $headers);
    }
}
