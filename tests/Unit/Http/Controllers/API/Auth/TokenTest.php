<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Auth\Token;
use App\Services\Users\Tokener;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;
use Tests\Unit\Http\Controllers\API\APITest;

class TokenTest extends APITest
{
    private const string TOKEN = 'test_token';
    private const string TYPE_INDEX = 'token_type';
    private const string TOKEN_INDEX = 'access_token';
    private const string EXPIRATION_INDEX = 'expires_in';

    public function testRequest(): void
    {
        $tokener = $this->createConfiguredMock(Tokener::class, ['getToken' => self::TOKEN]);
        $tokenManager = $this->createConfiguredMock(JWT::class, ['setToken' => new ReturnSelf(), 'getClaim' => time()]);

        $data = (new Token($tokenManager))->request($this->getRequest(), $tokener)->getData(true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey(self::TYPE_INDEX, $data);
        $this->assertArrayHasKey(self::TOKEN_INDEX, $data);
        $this->assertSame('bearer', $data[self::TYPE_INDEX]);
        $this->assertArrayHasKey(self::EXPIRATION_INDEX, $data);
        $this->assertSame(self::TOKEN, $data[self::TOKEN_INDEX]);
        $this->assertLessThanOrEqual(0, $data[self::EXPIRATION_INDEX]);
    }
}
