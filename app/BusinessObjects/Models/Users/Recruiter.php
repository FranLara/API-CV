<?php
declare(strict_types = 1);

namespace App\BusinessObjects\Models\Users;

use Database\Factories\RecruiterFactory;

class Recruiter extends User
{
	protected $fillable = ['id', 'email', 'name', 'password', 'language', 'linkedin_profile'];

	protected static function newFactory(): RecruiterFactory
	{
		return RecruiterFactory::new();
	}
}