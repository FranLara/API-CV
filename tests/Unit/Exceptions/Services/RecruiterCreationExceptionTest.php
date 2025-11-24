<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services;

use App\Exceptions\Services\RecruiterCreationException;
use Dingo\Api\Http\Response;
use Tests\TestCase;
use Tests\Utils\Recruiter as RecruiterUtils;

class RecruiterCreationExceptionTest extends TestCase
{
    use RecruiterUtils;

    private const string NAME_VARIABLE = 'name';
    private const string RECRUITER = 'recruiter';
    private const string PSSWD_VARIABLE = 'psswd';
    private const string EMAIL_VARIABLE = 'email';
    private const string LANGUAGE_VARIABLE = 'language';
    private const string LINKEDIN_VARIABLE = 'linkedinProfile';

    public function testConstructor(): void
    {
        $exception = new RecruiterCreationException($this->getRecruiter());

        $this->assertNotEmpty($exception->context());
        $this->assertArrayHasKey(self::RECRUITER, $exception->context());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $exception->getCode());
        $this->assertArrayHasKey(self::NAME_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::EMAIL_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::PSSWD_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame('en', $exception->context()[self::RECRUITER][self::LANGUAGE_VARIABLE]);
        $this->assertArrayHasKey(self::LANGUAGE_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertArrayHasKey(self::LINKEDIN_VARIABLE, $exception->context()[self::RECRUITER]);
        $this->assertSame('[HIDDEN]', $exception->context()[self::RECRUITER][self::PSSWD_VARIABLE]);
        $this->assertSame('test_name', $exception->context()[self::RECRUITER][self::NAME_VARIABLE]);
        $this->assertSame(self::EMAIL, $exception->context()[self::RECRUITER][self::EMAIL_VARIABLE]);
        $this->assertSame('The recruiter with email test@recruiter.com was not created.', $exception->getMessage());
        $this->assertSame('test_linkedin_profile.com', $exception->context()[self::RECRUITER][self::LINKEDIN_VARIABLE]);
    }
}
