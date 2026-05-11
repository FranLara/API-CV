<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use App\Services\Health\Checker;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\AssertableJson;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionException;

class HealthTest extends APITests
{
    private string $endpoint;

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function testCheck(): void
    {
        $this->getJson($this->endpoint, $this->getHeader())->assertJson(
            fn(AssertableJson $json) => $json->has(
                'components',
                fn(AssertableJson $components) => $components->where('database', Checker::STATUS_OK)
            )->where('timestamp', now()->toIso8601String())
        );
    }

    public function testOptions(): void
    {
        $methods = [Request::METHOD_GET, Request::METHOD_OPTIONS];
        $this->withHeaders($this->getHeader())->options($this->endpoint)->assertHeader(
            'Allow',
            implode(', ', $methods)
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = $this->domain . '/health';
    }
}
