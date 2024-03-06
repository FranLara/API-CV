<?php

namespace App\Console\Commands\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Console\Commands\User\Admin\Admin as AdminCommand;
use App\Notifications\User\Admin\Created;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Saver;
use App\Utils\Notifications as NotificationUtils;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class Create extends AdminCommand
{
	use NotificationUtils;
	private const CREATION_TRANSLATIONS = self::ADMIN_TRANSLATIONS . 'creation.';
	protected $description = 'This command creates an admin user asking by keyboard the username and the password.';

	public function __construct()
	{
		$this->signature = self::USER_SIGNATURE . 'create' . self::ADMIN_SIGNATURE;

		parent::__construct();
	}

	public function handle(Saver $saver, Retriever $retriever): void
	{
		do {
			$username = $this->ask(__(self::CREATION_TRANSLATIONS . 'username'));
		} while ((!$this->isUsernameUnique($retriever, $username)) && (!Str::of($username)->exactly(self::EXIT)));

		if (!Str::of($username)->lower()->exactly(self::EXIT)) {
			$this->createAdmin($saver, $username);
		}
	}

	private function isUsernameUnique(Retriever $retriever, string $username): bool
	{
		try {
			$retriever->retrieveByField('username', $username);
		}
		catch (ModelNotFoundException) {
			return true;
		}

		$this->error(__(self::CREATION_TRANSLATIONS . 'existing', ['username' => $username]));

		return false;
	}

	private function createAdmin(Saver $saver, string $username): void
	{
		$psswrd = $this->secret(__(self::CREATION_TRANSLATIONS . 'password'));
		$language = $this->ask(__(self::CREATION_TRANSLATIONS . 'language'), 1);

		$admin = new Admin($username, $this->getLanguage($language), $psswrd);

		$userSaved = $saver->save($admin);

		if ($userSaved) {
			$this->sendMailNotification(new Created($admin), $admin->getLanguage());
		}
	}
}
