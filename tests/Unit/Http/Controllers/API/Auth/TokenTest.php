<?php

namespace Tests\Unit\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Auth\Token;
use App\Services\Users\Tokener;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;
use Tests\TestCase;
use Tests\Utils\Request as RequestUtils;
use Tymon\JWTAuth\JWT;

class TokenTest extends TestCase
{
	use RequestUtils;
	private const TOKEN = 'test_token';
	private const TYPE_INDEX = 'token_type';
	private const TOKEN_INDEX = 'access_token';
	private const EXPIRATION_INDEX = 'expires_in';

	public function testRequest(): void
	{
		$tokener = $this->createConfiguredMock(Tokener::class, ['getToken' => self::TOKEN]);
		$tokenManager = $this->createConfiguredMock(JWT::class, ['setToken' => new ReturnSelf(), 'getClaim' => time()]);

		$data = (new Token())->request($this->getRequest(), $tokener, $tokenManager)
			->getData(true);

		$this->assertIsArray($data);
		$this->assertArrayHasKey(self::TYPE_INDEX, $data);
		$this->assertArrayHasKey(self::TOKEN_INDEX, $data);
		$this->assertSame('bearer', $data[self::TYPE_INDEX]);
		$this->assertArrayHasKey(self::EXPIRATION_INDEX, $data);
		$this->assertSame(self::TOKEN, $data[self::TOKEN_INDEX]);
		$this->assertLessThanOrEqual(0, $data[self::EXPIRATION_INDEX]);
	}
}
