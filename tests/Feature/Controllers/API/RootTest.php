<?php
declare(strict_types = 1);

namespace Tests\Feature\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\AssertableJson;

class RootTest extends APITest
{
	private const TYPE_INDEX = 'type';
	private const NAME_INDEX = 'name';
	private const STRING_TYPE = 'string';
	private const PARAMETER_INDEX = 'parameters';
	private const DESCRIPTION_INDEX = 'description';
	private const ENDPOINT_INDEX = 'endpointExample';
	private const ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
	private const TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'token.';
	private array $parameterIndexes = [self::TYPE_INDEX, self::NAME_INDEX];
	private array $resourceIndexes = [self::TYPE_INDEX, self::DESCRIPTION_INDEX, self::PARAMETER_INDEX,
		self::ENDPOINT_INDEX];

	public function testIndex(): void
	{
		$this->getJson($this->domain, $this->header)->assertJson(fn (AssertableJson $json) => $json->has('Resources', fn (AssertableJson $resources) => $resources->has('token', fn (AssertableJson $token) => $token->hasAll($this->resourceIndexes)
			->where(self::TYPE_INDEX, Request::METHOD_POST)
			->where(self::DESCRIPTION_INDEX, __(self::TOKEN_TRANSLATIONS . 'request'))
			->has(self::PARAMETER_INDEX, 2)
			->has(self::PARAMETER_INDEX . '.0', fn (AssertableJson $parameter) => $parameter->hasAll($this->parameterIndexes)
			->where(self::NAME_INDEX, 'username')
			->where(self::TYPE_INDEX, self::STRING_TYPE))
			->has(self::PARAMETER_INDEX . '.1', fn (AssertableJson $parameter) => $parameter->hasAll($this->parameterIndexes)
			->where(self::NAME_INDEX, 'password')
			->where(self::TYPE_INDEX, self::STRING_TYPE))
			->where(self::ENDPOINT_INDEX, $this->domain . '/token?username=username&password=password'))));
	}

	public function testOptions(): void
	{
		$this->withHeaders($this->header)
			->options($this->domain . '/allows')
			->assertHeader('Allow', implode(', ', [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST,
			Request::METHOD_PATCH]));
	}
}
