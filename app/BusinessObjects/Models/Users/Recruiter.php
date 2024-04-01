<?php
declare(strict_types = 1);

namespace App\BusinessObjects\Models\Users;

use Database\Factories\RecruiterFactory;

class Recruiter extends User
{
	public $timestamps = false;
	protected $fillable = ['password', 'language', 'linkedin_profile'];

	protected static function newFactory(): RecruiterFactory
	{
		return RecruiterFactory::new();
	}
}