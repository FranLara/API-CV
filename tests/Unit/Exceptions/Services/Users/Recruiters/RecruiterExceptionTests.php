<?php

declare(strict_types=1);

namespace Tests\Unit\Exceptions\Services\Users\Recruiters;

use Tests\TestCase;
use Tests\Utils\Recruiter as RecruiterUtils;

abstract class RecruiterExceptionTests extends TestCase
{
    use RecruiterUtils;

    protected const string NAME_VARIABLE = 'name';
    protected const string RECRUITER = 'recruiter';
    protected const string PSSWD_VARIABLE = 'psswd';
    protected const string EMAIL_VARIABLE = 'email';
    protected const string LANGUAGE_VARIABLE = 'language';
    protected const string IDENTIFIER_VARIABLE = 'identifier';
    protected const string LINKEDIN_VARIABLE = 'linkedinProfile';
}
