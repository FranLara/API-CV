<?php
declare(strict_types = 1);

namespace App\BusinessObjects\Models\Users;

use Database\Factories\TechnicianFactory;

class Technician extends User
{

	protected static function newFactory(): TechnicianFactory
	{
		return TechnicianFactory::new();
	}
}