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
    private const string COMPONENTS = 'components';

    #[DataProvider('providerComponents')]
    public function testIndex(array $components, int $expectedStatusCode = Response::HTTP_OK): void
    {
        $statuses = collect($components);
        $checkResponse = $this->controller->check($this->createConfiguredMock(Checker::class, ['check' => $statuses]));
        $statusCode = $checkResponse->getStatusCode();
        $check = json_decode($checkResponse->content(), true);

        $this->assertIsArray($check);
        $this->assertArrayHasKey('timestamp', $check);
        $this->assertArrayHasKey(self::COMPONENTS, $check);
        $this->assertEquals($expectedStatusCode, $statusCode);
        $this->assertCount($statuses->count(), $check[self::COMPONENTS]);
        $this->assertSame($statuses->toJson(), json_encode($check[self::COMPONENTS]));
    }

    public function testOptions(): void
    {
        $data = $this->controller->options();

        $expectedMethods = [Request::METHOD_GET, Request::METHOD_OPTIONS];

        $this->assertEquals(Response::HTTP_OK, $data->getStatusCode());
        $this->assertSame(implode(', ', $expectedMethods), $data->headers->get('Allow'));
    }

    public static function providerComponents(): array
    {
        return [[['database' => Checker::STATUS_OK]], [['database' => 'degraded'], Response::HTTP_SERVICE_UNAVAILABLE]];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new Health();
    }
}
