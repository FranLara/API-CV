<?php

declare(strict_types=1);

namespace App\Console\Commands\User\Admin;

use App\Console\Commands\User\User;

use function Laravel\Prompts\select;

abstract class Admin extends User
{
    protected const string ADMIN_SIGNATURE = 'Admin';
    protected const string ADMIN_TRANSLATIONS = self::TRANSLATIONS . 'admin.';

    protected function getLanguage(string $question, string $default): string
    {
        return select(label: $question, options: ['en' => 'English', 'es' => 'Castellano ', 'de' => 'Deutsch'],
            default: $default);
    }
}