<?php
declare(strict_types = 1);

namespace Tests\Unit\Http\Controllers\API;

use App\Http\Controllers\API\Root;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use Tests\Unit\Http\Controllers\API\APITest as APIController;

class RootTest extends APIController
{
	private const TYPE_INDEX = 'type';
	private const NAME_INDEX = 'name';
	private const TOKEN_PATH = 'token';
	private const STRING_TYPE = 'string';
	private const RESOURCES = 'Resources';
	private const PARAMETER_INDEX = 'parameters';
	private const DESCRIPTION_INDEX = 'description';
	private const ENDPOINT_INDEX = 'endpointExample';
	private const ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
	private const TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'token.';
	private Root $controller;

	public function testIndex(): void
	{
		$index = json_decode($this->controller->index($this->getRequest())
			->content(), true);

		$this->assertIsArray($index);
		$this->assertIsArray($index[self::RESOURCES]);
		$this->assertArrayHasKey(self::RESOURCES, $index);
		$this->assertIsArray($index[self::RESOURCES][self::TOKEN_PATH]);
		$this->assertArrayHasKey(self::TOKEN_PATH, $index[self::RESOURCES]);
		$this->assertArrayHasKey(self::TYPE_INDEX, $index[self::RESOURCES][self::TOKEN_PATH]);
		$this->assertIsArray($index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX]);
		$this->assertCount(2, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX]);
		$this->assertArrayHasKey(self::ENDPOINT_INDEX, $index[self::RESOURCES][self::TOKEN_PATH]);
		$this->assertIsArray($index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][0]);
		$this->assertIsArray($index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][1]);
		$this->assertArrayHasKey(self::PARAMETER_INDEX, $index[self::RESOURCES][self::TOKEN_PATH]);
		$this->assertArrayHasKey(self::DESCRIPTION_INDEX, $index[self::RESOURCES][self::TOKEN_PATH]);
		$this->assertSame(Request::METHOD_POST, $index[self::RESOURCES][self::TOKEN_PATH][self::TYPE_INDEX]);
		$this->assertArrayHasKey(self::NAME_INDEX, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][0]);
		$this->assertArrayHasKey(self::TYPE_INDEX, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][0]);
		$this->assertArrayHasKey(self::NAME_INDEX, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][1]);
		$this->assertArrayHasKey(self::TYPE_INDEX, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][1]);
		$this->assertSame('username', $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][0][self::NAME_INDEX]);
		$this->assertSame('password', $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][1][self::NAME_INDEX]);
		$this->assertSame(self::STRING_TYPE, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][0][self::TYPE_INDEX]);
		$this->assertSame(self::STRING_TYPE, $index[self::RESOURCES][self::TOKEN_PATH][self::PARAMETER_INDEX][1][self::TYPE_INDEX]);
		$this->assertSame(__(self::TOKEN_TRANSLATIONS . 'request'), $index[self::RESOURCES][self::TOKEN_PATH][self::DESCRIPTION_INDEX]);
		$this->assertSame('https://domain.test/token?username=username&password=password', $index[self::RESOURCES][self::TOKEN_PATH][self::ENDPOINT_INDEX]);
	}

	public function testOptions(): void
	{
		$data = $this->controller->options($this->getRequest());

		$this->assertEquals(Response::HTTP_OK, $data->getStatusCode());
		$this->assertSame('GET, OPTIONS, POST, PATCH', $data->headers->get('Allow'));
	}

	protected function setUp(): void
	{
		parent::setUp();

		$this->controller = new Root();
	}
}
