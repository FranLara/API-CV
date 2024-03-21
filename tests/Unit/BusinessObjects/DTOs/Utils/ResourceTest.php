<?php

namespace Tests\Unit\BusinessObjects\DTOs\Utils;

use App\BusinessObjects\DTOs\Utils\Resource;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use Tests\Utils\Request as RequestUtils;

class ResourceTest extends TestCase
{
	use RequestUtils;
	private const PATH = 'test_path';
	private const NAME = 'test_name';
	private const TYPE_INDEX = 'type';
	private const NAME_INDEX = 'name';
	private const PARAMETER_INDEX = 'parameters';
	private const DESCRIPTION = 'test_description';
	private const DESCRIPTION_INDEX = 'description';
	private const ENDPOINT_INDEX = 'endpointExample';

	/**
	 * @dataProvider providerGetResource
	 */
	public function testGetResource(array $parameters = [], string $type = Request::METHOD_GET): void
	{
		$resource = (new Resource($this->getRequest(), self::PATH, self::DESCRIPTION, $parameters, $type))->getResource();

		$this->assertIsArray($resource);
		$this->assertIsArray($resource[self::PATH]);
		$this->assertArrayHasKey(self::PATH, $resource);
		$this->assertArrayHasKey(self::TYPE_INDEX, $resource[self::PATH]);
		$this->assertSame($type, $resource[self::PATH][self::TYPE_INDEX]);
		$this->assertArrayHasKey(self::ENDPOINT_INDEX, $resource[self::PATH]);
		$this->assertArrayHasKey(self::PARAMETER_INDEX, $resource[self::PATH]);
		$this->assertArrayHasKey(self::DESCRIPTION_INDEX, $resource[self::PATH]);
		$this->assertSame(self::DESCRIPTION, $resource[self::PATH][self::DESCRIPTION_INDEX]);

		if (!empty($parameters)) {
			$this->assertParameters($parameters, $resource);
		}
		if (empty($parameters)) {
			$this->assertSame('https://domain.test/' . self::PATH, $resource[self::PATH][self::ENDPOINT_INDEX]);
		}
	}

	public static function providerGetResource(): array
	{
		return [[], [[[self::NAME_INDEX => self::NAME, self::TYPE_INDEX => 'string']]],
			[[[self::NAME_INDEX => self::NAME, self::TYPE_INDEX => 'int']]],
			[[[self::NAME_INDEX => self::NAME, self::TYPE_INDEX => 'bool']]],
			[
				[[self::NAME_INDEX => self::NAME, self::TYPE_INDEX => 'string'],
					[self::NAME_INDEX => self::NAME, self::TYPE_INDEX => 'int']]]];
	}

	private function assertParameters(array $parameters, array $resource): void
	{
		foreach ($parameters as $index => $parameter) {
			$this->assertArrayHasKey(self::NAME_INDEX, $resource[self::PATH][self::PARAMETER_INDEX][$index]);
			$this->assertArrayHasKey(self::TYPE_INDEX, $resource[self::PATH][self::PARAMETER_INDEX][$index]);
			$this->assertSame($parameter[self::NAME_INDEX], $resource[self::PATH][self::PARAMETER_INDEX][$index][self::NAME_INDEX]);
			$this->assertSame($parameter[self::TYPE_INDEX], $resource[self::PATH][self::PARAMETER_INDEX][$index][self::TYPE_INDEX]);
		}
	}
}
