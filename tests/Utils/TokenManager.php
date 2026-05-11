<?php

declare(strict_types=1);

namespace Tests\Utils;

use PHPOpenSourceSaver\JWTAuth\JWT;

trait TokenManager
{
    protected function getMockedTokenManager(): JWT
    {
        $mockedTokenManager = $this->createMock(JWT::class);
        $mockedTokenManager->method('check')->willReturn(true);
        $mockedTokenManager->method('setToken')->willReturnSelf();

        return $mockedTokenManager;
    }
}
