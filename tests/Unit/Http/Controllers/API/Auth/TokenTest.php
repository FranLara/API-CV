<?php

namespace Tests\Unit\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Auth\Token;
use App\Services\Users\Tokener;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;
use Tests\TestCase;
use Tymon\JWTAuth\JWT;
use Mockery;

class TokenTest extends TestCase
{
	private const TOKEN = 'test_token';
	private const TYPE_INDEX = 'token_type';
	private const TOKEN_INDEX = 'access_token';
	private const EXPIRATION_INDEX = 'expires_in';

	public function testRequest(): void
	{
		$request = Mockery::mock(Request::class, ['validate' => true, 'only' => []]);
		$tokener = $this->createConfiguredMock(Tokener::class, ['getToken' => self::TOKEN]);
		$tokenManager = $this->createConfiguredMock(JWT::class, ['setToken' => new ReturnSelf(), 'getClaim' => time()]);

		$data = (new Token())->request($request, $tokener, $tokenManager)->getData(true);

		$this->assertIsArray($data);
		$this->assertArrayHasKey(self::TYPE_INDEX, $data);
		$this->assertArrayHasKey(self::TOKEN_INDEX, $data);
		$this->assertSame('bearer', $data[self::TYPE_INDEX]);
		$this->assertArrayHasKey(self::EXPIRATION_INDEX, $data);
		$this->assertSame(self::TOKEN, $data[self::TOKEN_INDEX]);
		$this->assertLessThanOrEqual(0, $data[self::EXPIRATION_INDEX]);
	}
}
