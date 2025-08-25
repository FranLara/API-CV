<?php

declare(strict_types=1);

namespace Tests\Utils;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;

trait Recruiter
{
    protected const string PSSWD = 'test_password';
    protected const string EMAIL = 'test@recruiter.com';

    protected function getRecruiter(string $language = 'en'): RecruiterDTO
    {
        return new RecruiterDTO(
            name: 'test_name',
            email: self::EMAIL,
            psswd: self::PSSWD,
            language: $language,
            linkedinProfile: 'test_linkedin_profile.com'
        );
    }
}
