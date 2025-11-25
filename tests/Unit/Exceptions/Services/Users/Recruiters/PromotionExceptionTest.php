<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services\Users\Recruiters;

use App\Exceptions\Services\Users\Recruiters\PromotionException;
use Dingo\Api\Http\Response;

class PromotionExceptionTest extends RecruiterExceptionTests
{
    public function testConstructor(): void
    {
        $exception = new PromotionException($this->getRecruiter());

        $this->assertNotEmpty($exception->context());
        $this->assertArrayHasKey(self::RECRUITER, $exception->context());
        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $exception->getCode());
        $this->assertArrayHasKey(self::NAME_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::EMAIL_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::PSSWD_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame('en', $exception->context()[self::RECRUITER][self::LANGUAGE_VARIABLE]);
        $this->assertArrayHasKey(self::LANGUAGE_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::LINKEDIN_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame('[HIDDEN]', $exception->context()[self::RECRUITER][self::PSSWD_VARIABLE]);
        $this->assertSame('test_name', $exception->context()[self::RECRUITER][self::NAME_VARIABLE]);
        $this->assertSame(self::EMAIL, $exception->context()[self::RECRUITER][self::EMAIL_VARIABLE]);
        $this->assertSame('The recruiter with email test@recruiter.com was not promoted.', $exception->getMessage());
        $this->assertSame('test_linkedin_profile.com', $exception->context()[self::RECRUITER][self::LINKEDIN_VARIABLE]);
    }
}
