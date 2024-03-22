<?php

namespace App\Console\Commands\User\Admin;

use App\Console\Commands\User\User;

abstract class Admin extends User
{
	protected const ADMIN_SIGNATURE = 'Admin';
	protected const ADMIN_TRANSLATIONS = self::TRANSLATIONS . 'admin.';

	protected function getLanguage(int $language): string
	{
		return match ($language) {2 => 'es',3 => 'de',default => 'en'
		};
	}
}