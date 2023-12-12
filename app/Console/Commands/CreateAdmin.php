<?php

namespace App\Console\Commands;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Notifications\AdminCreated;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    private const EXIT = 'exit';
    private const TRANSLATIONS = 'command.creation.admin.';

    protected $signature = 'create:admin';
    protected $description = 'This command creates an admin user asking by keyboard the username and the password.';

    public function handle(Saver $saver, Retriever $retriever): void
    {
        do {
            $username = $this->ask(__(self::TRANSLATIONS . 'username'));
        } while ((!$this->isUsernameUnique($retriever, $username)) || (!Str::of($username)->exactly(self::EXIT)));

        if (!Str::of($username)->exactly(self::EXIT)) {
            $this->createAdmin($saver, $username);
        }
    }

    private function isUsernameUnique(Retriever $retriever, string $username): bool
    {
        try {
            $retriever->retrieveByField('username', $username);
        } catch (ModelNotFoundException) {
            return true;
        }

        $this->error(__(self::TRANSLATIONS . 'existing', ['username' => $username]));

        return false;
    }

    private function createAdmin(Saver $saver, string $username): void
    {
        $password = $this->secret(__(self::TRANSLATIONS . 'password'));
        $language = $this->ask(__(self::TRANSLATIONS . 'language'), 1);

        $admin = new Admin($username, $this->getLanguage($language), $password);

        $userSaved = $saver->save($admin);

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
