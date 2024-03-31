<?php
declare(strict_types = 1);

namespace App\Console\Commands\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Console\Commands\User\Admin\Admin as AdminCommand;
use App\Notifications\User\Admin\Updated;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;
use App\Utils\Notifications as NotificationUtils;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class Update extends AdminCommand
{
	use NotificationUtils;
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
		} while ((!Str::of($admin->getUsername())->lower()->exactly(self::EXIT)) && (empty($admin->getIdentifier())));

		if (!empty($admin->getIdentifier())) {
			$this->updateAdmin($saver, $admin);
		}
	}

	private function getAdmin(Retriever $retriever): Admin
	{
		$username = $this->ask(__(self::UPDATE_TRANSLATIONS . 'username'));

		if (Str::of($username)->lower()->exactly(self::EXIT)) {
			return new Admin($username);
		}

		try {
			return $retriever->retrieveByField('username', $username);
		}
		catch (ModelNotFoundException) {
			$this->error(__(self::UPDATE_TRANSLATIONS . 'non_existing', ['username' => $username]));
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
			$this->sendMailNotification(new Updated($admin), $admin->getLanguage());
		}
	}

	private function getDefLang(string $language): string
	{
		return match ($language) {'es' => 2,'de' => 3,default => 1,
		};
	}
}
