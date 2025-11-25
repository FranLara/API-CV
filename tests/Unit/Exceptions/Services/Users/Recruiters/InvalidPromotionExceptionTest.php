<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services\Users\Recruiters;

use App\Exceptions\Services\Users\Recruiters\InvalidPromotionException;
use Dingo\Api\Http\Response;

class InvalidPromotionExceptionTest extends RecruiterExceptionTests
{
    public function testConstructor(): void
    {
        $recruiter = $this->getRecruiterWithoutPsswd();
        $recruiter->setLinkedinProfile(null);

        $exception = new InvalidPromotionException($recruiter);

        $this->assertNotEmpty($exception->context());
        $this->assertArrayHasKey(self::RECRUITER, $exception->context());
        $this->assertEquals(Response::HTTP_CONFLICT, $exception->getCode());
        $this->assertArrayHasKey(self::NAME_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::EMAIL_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame('The recruiter is invalid to be promoted.', $exception->getMessage());
        $this->assertSame('en', $exception->context()[self::RECRUITER][self::LANGUAGE_VARIABLE]);
        $this->assertArrayHasKey(self::LANGUAGE_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayNotHasKey(self::PSSWD_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame('test_name', $exception->context()[self::RECRUITER][self::NAME_VARIABLE]);
        $this->assertArrayNotHasKey(self::LINKEDIN_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame(self::EMAIL, $exception->context()[self::RECRUITER][self::EMAIL_VARIABLE]);
    }
}
