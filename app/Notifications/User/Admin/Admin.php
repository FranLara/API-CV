<?php

declare(strict_types=1);

namespace App\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\Notifications\User\User;
use Illuminate\Notifications\Messages\MailMessage;

abstract class Admin extends User
{
    protected const string ADMIN_TRANSLATIONS = self::USER_TRANSLATIONS . 'admin.';

    protected function getMailMessage(AdminDTO $admin, string $operationTranslation): MailMessage
    {
        $username = ['username' => $admin->getUsername()];

        $greeting = __(self::USER_TRANSLATIONS . 'greeting');
        $line1 = __($operationTranslation . 'line_1', $username);
        $subject = __($operationTranslation . 'subject', $username);
        $line2 = __(self::USER_TRANSLATIONS . 'line_2', ['language' => $this->getLanguage($admin->getLanguage())]);

        return new MailMessage()->subject($subject)->greeting($greeting)->line($line1)->line($line2);
    }
}
