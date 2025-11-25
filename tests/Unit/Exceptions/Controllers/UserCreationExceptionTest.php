<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Controllers;

use App\Exceptions\Controllers\UserCreationException;
use App\Exceptions\Services\Users\Recruiters\CreationException;
use Dingo\Api\Http\Response;
use Tests\TestCase;
use Tests\Utils\Recruiter as RecruiterUtils;

class UserCreationExceptionTest extends TestCase
{
    use RecruiterUtils;

    private const string USER = 'user';
    private const string MESSAGE = 'message';

    public function testConstructor(): void
    {
        $exception = new UserCreationException(new CreationException($this->getRecruiter()));

        $this->assertNotEmpty($exception->context());
        $this->assertArrayHasKey(self::USER, $exception->context());
        $this->assertArrayHasKey(self::MESSAGE, $exception->context());
        $this->assertArrayHasKey('recruiter', $exception->context()[self::USER]);
        $this->assertSame('The user was not created.', $exception->getMessage());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $exception->getStatusCode());
        $this->assertSame(
            'The recruiter with email test@recruiter.com was not created.',
            $exception->context()[self::MESSAGE]
        );
    }
}
