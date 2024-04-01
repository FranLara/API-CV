<?php
declare(strict_types = 1);

namespace App\BusinessObjects\Models\Users;

use Database\Factories\AdminFactory;

class Admin extends User
{
	protected $fillable = ['username'];

	protected static function newFactory(): AdminFactory
	{
		return AdminFactory::new();
	}
}