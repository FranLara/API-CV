<?php
declare(strict_types = 1);

namespace App\BusinessObjects\Models\Users;

use Database\Factories\AdminFactory;

class Admin extends User
{
	public $timestamps = false;
	protected $fillable = ['username', 'password', 'language'];

	protected static function newFactory(): AdminFactory
	{
		return AdminFactory::new();
	}
}