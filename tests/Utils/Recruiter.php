<?php

declare(strict_types=1);

namespace Tests\Utils;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;

trait Recruiter
{
    protected const string PSSWD = 'test_password';
    protected const string EMAIL = 'test@recruiter.com';
    protected const string IDENTIFIER = 'test_identifier';

    protected function getFullRecruiter(string $language = 'en'): RecruiterDTO
    {
        $recruiter = $this->getRecruiterWithoutIdentifier($language);
        $recruiter->setIdentifier(self::IDENTIFIER);

        return $recruiter;
    }

    protected function getRecruiterWithoutPsswd(string $language = 'en'): RecruiterDTO
    {
        $recruiter = $this->getRecruiter($language);
        $recruiter->setIdentifier(self::IDENTIFIER);

        return $recruiter;
    }

    protected function getRecruiterWithoutIdentifier(string $language = 'en'): RecruiterDTO
    {
        $recruiter = $this->getRecruiter($language);
        $recruiter->setPsswd(self::PSSWD);

        return $recruiter;
    }

    private function getRecruiter(string $language): RecruiterDTO
    {
        return new RecruiterDTO(
            name: 'test_name',
            email: self::EMAIL,
            language: $language,
            linkedinProfile: 'test_linkedin_profile.com'
        );
    }
}
