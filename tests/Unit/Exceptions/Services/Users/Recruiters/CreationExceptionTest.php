<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services\Users\Recruiters;

use App\Exceptions\Services\Users\Recruiters\CreationException;
use Dingo\Api\Http\Response;

class CreationExceptionTest extends RecruiterExceptionTests
{
    public function testConstructor(): void
    {
        $exception = new CreationException($this->getRecruiterWithoutIdentifier());
        $context = $exception->context();

        $this->assertNotEmpty($context);
        $this->assertArrayHasKey(self::RECRUITER, $context);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $exception->getCode());
        $this->assertArrayHasKey(self::NAME_VARIABLE, $context[self::RECRUITER]);
        $this->assertArrayHasKey(self::EMAIL_VARIABLE, $context[self::RECRUITER]);
        $this->assertArrayHasKey(self::PSSWD_VARIABLE, $context[self::RECRUITER]);
        $this->assertSame('en', $context[self::RECRUITER][self::LANGUAGE_VARIABLE]);
        $this->assertArrayHasKey(self::LANGUAGE_VARIABLE, $context[self::RECRUITER]);
        $this->assertArrayHasKey(self::LINKEDIN_VARIABLE, $context[self::RECRUITER]);
        $this->assertSame('[HIDDEN]', $context[self::RECRUITER][self::PSSWD_VARIABLE]);
        $this->assertSame('test_name', $context[self::RECRUITER][self::NAME_VARIABLE]);
        $this->assertSame(self::EMAIL, $context[self::RECRUITER][self::EMAIL_VARIABLE]);
        $this->assertArrayNotHasKey(self::IDENTIFIER_VARIABLE, $context[self::RECRUITER]);
        $this->assertSame('test_linkedin_profile.com', $context[self::RECRUITER][self::LINKEDIN_VARIABLE]);
        $this->assertSame('The recruiter with email test@recruiter.com was not created.', $exception->getMessage());
    }
}
