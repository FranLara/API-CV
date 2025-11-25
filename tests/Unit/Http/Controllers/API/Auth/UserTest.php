<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API\Auth;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\Exceptions\Controllers\UserCreationException;
use App\Exceptions\Services\Users\Recruiters\CreationException;
use App\Http\Controllers\API\Auth\User;
use App\Services\Users\Recruiters\Creator;
use Dingo\Api\Http\Response;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\Unit\Http\Controllers\API\APITests;

class UserTest extends APITests
{
    public function testRequest(): void
    {
        $data = new User()->request($this->getRequest(), $this->createMock(Creator::class));

        $this->assertEquals(Response::HTTP_CREATED, $data->getStatusCode());
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    #[DataProvider('providerException')]
    public function testRequestException(Exception $expectedException, Exception $exception): void
    {
        $this->expectException(get_class($expectedException));

        $creator = $this->createMock(Creator::class);
        $creator->method('create')->willThrowException($exception);

        new User()->request($this->getRequest(), $creator);
    }

    public static function providerException(): array
    {
        $recruiterException = new CreationException(new Recruiter());

        return [
            [new UserCreationException($recruiterException), $recruiterException],
            [new HttpException(Response::HTTP_INTERNAL_SERVER_ERROR), new Exception()],
        ];
    }
}
