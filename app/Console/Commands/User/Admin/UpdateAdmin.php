<?php

namespace App\Console\Commands\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Console\Commands\User\Admin\Admin as AdminCommand;
use App\Notifications\AdminCreated;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UpdateAdmin extends AdminCommand
{
    private const UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';

    protected $description = 'This command updates an admin user asking by keyboard the username and the new password.';

    public function __construct()
    {
        $this->signature = self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE;

        parent::__construct();
    }

    public function handle(Saver $saver, Retriever $retriever): void
    {
        do {
            $admin = $this->getAdmin($retriever);
        } while ((!Str::of($admin->getUsername())->exactly(self::EXIT)) && (empty($admin->getIdentifier())));

        if (!empty($admin->getIdentifier())) {
            $this->updateAdmin($saver, $admin);
        }
    }

    private function getAdmin(Retriever $retriever): Admin
    {
        $username = $this->ask(__(self::UPDATE_TRANSLATIONS . 'username'));

        if (Str::of($username)->exactly(self::EXIT)) {
            return new Admin($username);
        }

        try {
            return $retriever->retrieveByField('username', $username);
        } catch (ModelNotFoundException) {
            $this->error(__(self::UPDATE_TRANSLATIONS . 'existing', ['username' => $username]));
        }

        return new Admin();
    }

    private function updateAdmin(Saver $saver, Admin $admin): void
    {
        $admin->setPsswd($this->secret(__(self::UPDATE_TRANSLATIONS . 'password')));
        $language = $this->ask(__(self::UPDATE_TRANSLATIONS . 'language'), $this->getDefLang($admin->getLanguage()));

        $admin->setLanguage($this->getLanguage($language));

        $userSaved = $saver->save($admin);

        if ($userSaved) {
            Notification::route('mail', config('mail.notifications.internal'))->notify(new AdminCreated($admin));
        }
    }

    private function getDefLang(string $language): string
    {
        return match ($language) {
            'es' => 2,
            'de' => 3,
            default => 1,
        };
    }
}
