<?php
declare(strict_types = 1);

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

abstract class User extends Command
{
	protected const string EXIT = 'exit';
	protected const string USER_SIGNATURE = 'user:';
	protected const string TRANSLATIONS = 'command.user.';
}