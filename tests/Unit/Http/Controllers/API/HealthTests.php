<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API;

use App\Http\Controllers\API\Health;
use App\Services\Health\Checker;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\DataProvider;

class HealthTests extends APITests
{
    #[DataProvider('providerStatus')]
    public function testIndex(string $status, int $expectedStatusCode = Response::HTTP_OK): void
    {
        $checkResponse = $this->controller->check($this->createConfiguredMock(Checker::class, ['check' => $status]));
        $statusCode = $checkResponse->getStatusCode();
        $check = json_decode($checkResponse->content(), true);

        $this->assertIsArray($check);
        $this->assertArrayHasKey('status', $check);
        $this->assertSame($status, $check['status']);
        $this->assertArrayHasKey('timestamp', $check);
        $this->assertEquals($expectedStatusCode, $statusCode);
    }

    public function testOptions(): void
    {
        $data = $this->controller->options();

        $expectedMethods = [Request::METHOD_GET, Request::METHOD_OPTIONS];

        $this->assertEquals(Response::HTTP_OK, $data->getStatusCode());
        $this->assertSame(implode(', ', $expectedMethods), $data->headers->get('Allow'));
    }

    public static function providerStatus(): array
    {
        return [[Checker::STATUS_OK], ['degraded', Response::HTTP_SERVICE_UNAVAILABLE]];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new Health();
    }
}
