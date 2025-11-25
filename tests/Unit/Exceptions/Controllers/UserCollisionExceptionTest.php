<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Controllers;

use App\Exceptions\Controllers\UserCollisionException;
use App\Exceptions\Services\TokenUserCollisionException;
use Dingo\Api\Http\Response;
use Tests\TestCase;

class UserCollisionExceptionTest extends TestCase
{
    public function testConstructor(): void
    {
        $exception = new UserCollisionException(new TokenUserCollisionException('test_username'));
        $context = $exception->context();

        $this->assertNotEmpty($context);
        $this->assertArrayHasKey('message', $context);
        $this->assertArrayHasKey('username', $context);
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getStatusCode());
        $this->assertSame('There is a collision with the given username.', $exception->getMessage());
    }
}
