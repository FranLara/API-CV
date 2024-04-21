<?php
declare(strict_types = 1);

namespace Tests\Unit\Notifications\User\Recruiter;

use App\BusinessObjects\DTOs\Users\Recruiter;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

abstract class RecruiterTest extends TestCase
{
	protected const PSSWD = 'test_password';
	protected const EMAIL = 'test_email@email.com';

	protected function getRecruiter(string $language): Recruiter
	{
		$recruiter = new Recruiter(self::EMAIL, 'test_name', $language, self::PSSWD, 'test_linkedin_profile.com');
		Lang::setLocale($recruiter->getLanguage());

		return $recruiter;
	}
}
