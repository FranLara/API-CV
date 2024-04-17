<?php

declare(strict_types=1);

namespace App\Notifications\User\Admin;

use App\Notifications\User\User;

abstract class Admin extends User
{
    protected const string ADMIN_TRANSLATIONS = self::USER_TRANSLATIONS . 'admin.';
}
