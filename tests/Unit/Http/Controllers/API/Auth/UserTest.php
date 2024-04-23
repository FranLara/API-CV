<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Controllers\UserCreationException;
use App\Exceptions\Services\RecruiterCreationException;
use App\Http\Controllers\API\Auth\User;
use App\Services\Users\Recruiters\Creator;
use Dingo\Api\Http\Response;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\Unit\Http\Controllers\API\APITest;

class UserTest extends APITest
{
    public function testRequest(): void
    {
        $data = (new User())->request($this->getRequest(), $this->createMock(Creator::class));

        $this->assertEquals(Response::HTTP_CREATED, $data->getStatusCode());
    }

    /**
     * @dataProvider providerException
     */
    public function testRequestException(Exception $expectedException, Exception $exception): void
    {
        $this->expectException(get_class($expectedException));

        $creator = $this->createMock(Creator::class);
        $creator->method('create')->willThrowException($exception);
        (new User())->request($this->getRequest(), $creator);
    }

    public static function providerException(): array
    {
        $recruiterException = new RecruiterCreationException(new Recruiter());

        return [
            [new HttpException(Response::HTTP_BAD_REQUEST), new Exception()],
            [new UserCreationException($recruiterException), $recruiterException],
        ];
    }
}
