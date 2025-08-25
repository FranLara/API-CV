<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Auth\Token;
use App\Services\Users\Tokener;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Factory;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPOpenSourceSaver\JWTAuth\Manager;
use PHPOpenSourceSaver\JWTAuth\Payload;
use PHPOpenSourceSaver\JWTAuth\Token as JWTToken;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\Stub\ReturnSelf;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tests\Unit\Http\Controllers\API\APITests;

class TokenTest extends APITests
{
    private const string TOKEN = 'test_token';
    private const string TYPE_INDEX = 'token_type';
    private const string TOKEN_INDEX = 'access_token';
    private const string EXPIRATION_INDEX = 'expires_in';

    /**
     * @throws Exception
     */
    public function testRequest(): void
    {
        $tokener = $this->createConfiguredMock(Tokener::class, ['getToken' => self::TOKEN]);
        $tokenManager = $this->createConfiguredMock(JWT::class, ['setToken' => new ReturnSelf(), 'getClaim' => time()]);

        $data = new Token($tokenManager)->request($this->getRequest(), $tokener)->getData(true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey(self::TYPE_INDEX, $data);
        $this->assertArrayHasKey(self::TOKEN_INDEX, $data);
        $this->assertSame('bearer', $data[self::TYPE_INDEX]);
        $this->assertArrayHasKey(self::EXPIRATION_INDEX, $data);
        $this->assertSame(self::TOKEN, $data[self::TOKEN_INDEX]);
        $this->assertLessThanOrEqual(0, $data[self::EXPIRATION_INDEX]);
    }

    public function testRefresh(): void
    {
        $data = new Token($this->getTokenManager())->refresh($this->getRequest(['bearerToken' => '']))->getData(true);

        $this->assertIsArray($data);
        $this->assertArrayHasKey(self::TYPE_INDEX, $data);
        $this->assertArrayHasKey(self::TOKEN_INDEX, $data);
        $this->assertSame('bearer', $data[self::TYPE_INDEX]);
        $this->assertArrayHasKey(self::EXPIRATION_INDEX, $data);
        $this->assertSame(self::TOKEN, $data[self::TOKEN_INDEX]);
        $this->assertLessThanOrEqual(0, $data[self::EXPIRATION_INDEX]);
    }

    /**
     * @throws Exception
     */
    public function testRefreshUnauthorizedHttpException(): void
    {
        $this->expectException(UnauthorizedHttpException::class);

        $tokenManager = $this->createMock(JWT::class);
        $tokenManager->method('setToken')->willThrowException(new JWTException());

        new Token($tokenManager)->refresh($this->getRequest(['bearerToken' => '']));
    }

    /**
     * @throws Exception
     */
    private function getTokenManager(): JWT
    {
        $payload = $this->createConfiguredMock(Payload::class, ['toArray' => ['exp' => 0]]);
        $factoryMethods = ['customClaims' => new ReturnSelf(), 'make' => $payload];
        $factory = $this->createConfiguredMock(Factory::class, $factoryMethods);
        $token = $this->createConfiguredMock(JWTToken::class, ['get' => self::TOKEN]);
        $managerMethods = ['getPayloadFactory' => $factory, 'encode' => $token];
        $manager = $this->createConfiguredMock(Manager::class, $managerMethods);
        $methods = [
            'getClaim'   => time(),
            'getPayload' => $payload,
            'manager'    => $manager,
            'setToken'   => new ReturnSelf(),
        ];

        return $this->createConfiguredMock(JWT::class, $methods);
    }
}
