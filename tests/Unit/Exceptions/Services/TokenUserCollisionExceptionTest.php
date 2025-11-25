<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services;

use App\Exceptions\Services\TokenUserCollisionException;
use Dingo\Api\Http\Response;
use Tests\TestCase;

class TokenUserCollisionExceptionTest extends TestCase
{
    private const string USERNAME = 'test_username';
    private const string USERNAME_VARIABLE = 'username';

    public function testConstructor(): void
    {
        $exception = new TokenUserCollisionException(self::USERNAME);
        $context = $exception->context();

        $this->assertNotEmpty($context);
        $this->assertArrayHasKey(self::USERNAME_VARIABLE, $context);
        $this->assertSame(self::USERNAME, $context[self::USERNAME_VARIABLE]);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getCode());
        $this->assertSame('User collision for the username test_username generating a JWT.', $exception->getMessage());
    }
}
