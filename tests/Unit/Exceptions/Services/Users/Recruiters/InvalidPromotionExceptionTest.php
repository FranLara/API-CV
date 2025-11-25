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
        $context = $exception->context();

        $this->assertNotEmpty($context);
        $this->assertArrayHasKey(self::RECRUITER, $context);
        $this->assertEquals(Response::HTTP_CONFLICT, $exception->getCode());
        $this->assertArrayHasKey(self::NAME_VARIABLE, $context[self::RECRUITER]);
        $this->assertArrayHasKey(self::EMAIL_VARIABLE, $context[self::RECRUITER]);
        $this->assertSame('en', $context[self::RECRUITER][self::LANGUAGE_VARIABLE]);
        $this->assertArrayHasKey(self::LANGUAGE_VARIABLE, $context[self::RECRUITER]);
        $this->assertArrayNotHasKey(self::PSSWD_VARIABLE, $context[self::RECRUITER]);
        $this->assertSame('test_name', $context[self::RECRUITER][self::NAME_VARIABLE]);
        $this->assertArrayNotHasKey(self::LINKEDIN_VARIABLE, $context[self::RECRUITER]);
        $this->assertSame(self::EMAIL, $context[self::RECRUITER][self::EMAIL_VARIABLE]);
        $this->assertSame('The recruiter is invalid to be promoted.', $exception->getMessage());
    }
}
