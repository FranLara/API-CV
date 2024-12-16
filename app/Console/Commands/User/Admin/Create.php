<?php

declare(strict_types=1);

namespace App\Console\Commands\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Console\Commands\User\Admin\Admin as AdminCommand;
use App\Notifications\User\Admin\Created;
use App\Services\Saver;
use App\Services\Retriever;
use App\Utils\Notifications as NotificationUtils;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class Create extends AdminCommand
{
    use NotificationUtils;

    private const string CREATION_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'creation.';

    protected $description = 'This command creates an admin user asking by keyboard the username and the password.';

    public function __construct(protected readonly Saver $saver, protected readonly Retriever $retriever)
    {
        $this->signature = self::USER_SIGNATURE . 'create' . self::ADMIN_SIGNATURE;

        parent::__construct();
    }

    public function handle(): void
    {
        do {
            $username = text(label: __(self::CREATION_TRANSLATIONS . 'username.label'), required: true,
                hint: __(self::CREATION_TRANSLATIONS . 'username.hint'));
        } while ((!$this->isUsernameUnique($username)) && (!Str::of($username)->exactly(self::EXIT)));

        if (!Str::of($username)->lower()->exactly(self::EXIT)) {
            $this->createAdmin($username);
        }
    }

    private function isUsernameUnique(string $username): bool
    {
        try {
            $this->retriever->retrieveByField('username', $username);
        } catch (ModelNotFoundException) {
            return true;
        }

        $this->error(__(self::CREATION_TRANSLATIONS . 'existing', ['username' => $username]));

        return false;
    }

    private function createAdmin(string $username): void
    {
        $psswd = password(label: __(self::CREATION_TRANSLATIONS . 'password'), required: true);
        $language = $this->getLanguage(__(self::CREATION_TRANSLATIONS . 'language'), 'en');

        $admin = new Admin(username: $username, psswd: $psswd, language: $language);

        $userSaved = $this->saver->save($admin);

        if ($userSaved) {
            $this->sendMailNotification(new Created($admin), $admin->getLanguage());
        }
    }
}
