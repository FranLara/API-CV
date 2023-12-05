<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use app\DTOs\Users\Admin;

class CreateAdmin extends Command
{
    protected $signature = 'create:admin';
    protected $description = 'This command creates an admin user asking by keyboard the username and the password.';
    private $translations = 'command.creation.admin.';

    public function handle(): void
    {
        $username = $this->ask(trans($this->translations . 'username'));
        $password = $this->secret(trans($this->translations . 'password'));
        $language = $this->ask(trans($this->translations . 'language'), 1);

        $admin = new Admin($username, $password, $this->getLanguage($language));
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
