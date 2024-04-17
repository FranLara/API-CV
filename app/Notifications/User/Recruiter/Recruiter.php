<?php

declare(strict_types=1);

namespace App\Notifications\User\Recruiter;

use App\Notifications\User\User;

abstract class Recruiter extends User
{
    protected const string RECRUITER_TRANSLATIONS = self::USER_TRANSLATIONS . 'recruiter.';
}
