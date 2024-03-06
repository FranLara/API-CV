<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

abstract class User extends Command
{
    protected const EXIT = 'exit';
    protected const USER_SIGNATURE = 'user:';
    protected const TRANSLATIONS = 'command.user.';
}