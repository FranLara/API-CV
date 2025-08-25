<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API\Auth;

use App\Http\Controllers\API\API as APIController;
use Dingo\Api\Http\Response;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\Controllers\API\APITests;

use function collect;

class UserTest extends APITests
{
    #[DataProvider('providerUsers')]
    public function testRequest(int $expectedStatusCode, string $email = ''): void
    {
        $response = $this->post($this->domain . '/accounts', $this->getUser($email), $this->getHeader());

        $this->assertEquals($expectedStatusCode, $response->getStatusCode());

        if ($response->getStatusCode() == Response::HTTP_CREATED) {
            $this->assertDatabaseCount('jobs', 2);
            $this->assertDatabaseCount('recruiters', 1);
            $this->assertDatabaseHas('jobs', ['queue' => 'listeners']);
            $this->assertDatabaseHas('recruiters', ['email' => $email]);
        }
    }

    public static function providerUsers(): array
    {
        return [[Response::HTTP_UNPROCESSABLE_ENTITY], [Response::HTTP_CREATED, 'test@recruiter.com']];
    }

    private function getUser(string $email): array
    {
        return [
            APIController::EMAIL_PARAMETER    => $email,
            APIController::LINKEDIN_PARAMETER => fake()->url,
            APIController::NAME_PARAMETER     => fake()->name,
            APIController::LANGUAGE_PARAMETER => collect(['es', 'en'])->random(),
        ];
    }
}
