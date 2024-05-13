<?php

declare(strict_types=1);

namespace App\Console\Commands\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Console\Commands\User\Admin\Admin as AdminCommand;
use App\Notifications\User\Admin\Updated;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;
use App\Utils\Notifications as NotificationUtils;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class Update extends AdminCommand
{
    use NotificationUtils;

    private const string UPDATE_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'update.';
    protected $description = 'This command updates an admin user asking by keyboard the username and the new password.';

    public function __construct(Saver $saver, Retriever $retriever)
    {
        $this->signature = self::USER_SIGNATURE . 'update' . self::ADMIN_SIGNATURE;

        parent::__construct($saver, $retriever);
    }

    public function handle(): void
    {
        do {
            $admin = $this->getAdmin();
        } while ((!Str::of($admin->getUsername())->lower()->exactly(self::EXIT)) && (empty($admin->getIdentifier())));

        if (!empty($admin->getIdentifier())) {
            $this->updateAdmin($admin);
        }
    }

    private function getAdmin(): Admin
    {
        $username = text(label: __(self::UPDATE_TRANSLATIONS . 'username.label'), required: true,
            hint: __(self::UPDATE_TRANSLATIONS . 'username.hint'));

        if (Str::of($username)->lower()->exactly(self::EXIT)) {
            return new Admin($username);
        }

        try {
            return $this->retriever->retrieveByField('username', $username);
        } catch (ModelNotFoundException) {
            $this->error(__(self::UPDATE_TRANSLATIONS . 'non_existing', ['username' => $username]));
        }

        return new Admin();
    }

    private function updateAdmin(Admin $admin): void
    {
        $admin->setPsswd(password(label: __(self::UPDATE_TRANSLATIONS . 'password'), required: true));
        $language = $this->getLanguage(__(self::UPDATE_TRANSLATIONS . 'language'), $admin->getLanguage());

        $admin->setLanguage($language);

        $userSaved = $this->saver->save($admin);

        if ($userSaved) {
            $this->sendMailNotification(new Updated($admin), $admin->getLanguage());
        }
    }
}
