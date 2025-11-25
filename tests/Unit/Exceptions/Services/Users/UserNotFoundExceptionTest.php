<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services\Users;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\DTOs\Users\User;
use App\Exceptions\Services\Users\UserNotFoundException;
use Dingo\Api\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UserNotFoundExceptionTest extends TestCase
{
    private const string USER = 'user';

    #[DataProvider('providerUser')]
    public function testConstructor(User $user, string $field, string $expectedMessage): void
    {
        $exception = new UserNotFoundException($user, $field);

        $this->assertNotEmpty($exception->context());
        $this->assertArrayHasKey('field', $exception->context());
        $this->assertArrayHasKey(self::USER, $exception->context());
        $this->assertSame($expectedMessage, $exception->getMessage());
        $this->assertArrayHasKey($field, $exception->context()[self::USER]);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $exception->getCode());
    }

    public static function providerUser(): array
    {
        return [
            [
                new Recruiter(email: 'test@recruiter.com'),
                'email',
                sprintf('The user type %s was not found by its field %s.', Recruiter::class, 'email'),
            ],
        ];
    }
}
