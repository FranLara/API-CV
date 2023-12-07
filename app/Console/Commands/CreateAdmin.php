<?php

namespace App\Console\Commands;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Notifications\AdminCreated;
use App\Services\Users\Admins\Saver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class CreateAdmin extends Command
{
    private const TRANSLATIONS = 'command.creation.admin.';
    protected $signature = 'create:admin';
    protected $description = 'This command creates an admin user asking by keyboard the username and the password.';

    public function handle(Saver $saver): void
    {
        $username = $this->ask(__(self::TRANSLATIONS . 'username'));
        $password = $this->secret(__(self::TRANSLATIONS . 'password'));
        $language = $this->ask(__(self::TRANSLATIONS . 'language'), 1);

        $admin = new Admin($username, $password, $this->getLanguage($language));

        $userSaved = true; //$saver->save($admin);

        if ($userSaved) {
            Notification::route('mail', 'testing@test.com')->notify(new AdminCreated($admin));
        }
    }

    private function getLanguage(int $language): string
    {
        return match ($language) {
            2 => 'es',
            3 => 'de',
            default => 'en'
        };
    }
}
