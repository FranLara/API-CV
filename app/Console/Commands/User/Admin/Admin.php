<?php

declare(strict_types=1);

namespace App\Console\Commands\User\Admin;

use App\Console\Commands\User\User;

use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;

use function Laravel\Prompts\select;

abstract class Admin extends User
{
    protected const string ADMIN_SIGNATURE = 'Admin';
    protected const string ADMIN_TRANSLATIONS = self::TRANSLATIONS . 'admin.';

    public function __construct(protected Saver $saver, protected Retriever $retriever)
    {
        parent::__construct();
    }

    protected function getLanguage(string $question, string $default): string
    {
        return select(label: $question, options: ['en' => 'English', 'es' => 'Castellano ', 'de' => 'Deutsch'],
            default: $default);
    }
}