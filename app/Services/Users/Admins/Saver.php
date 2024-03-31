<?php
declare(strict_types = 1);

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Saver as UserSaver;

class Saver extends UserSaver
{

	public function __construct(Mapper $mapper)
	{
		$this->mapper = $mapper;
	}

	public function save(DTO $admin): bool
	{
		$model = $this->getMappedModel($admin);

		if ($model->isDirty()) {
			return $model->save();
		}

		return true;
	}

	private function getMappedModel(Admin $admin): AdminModel
	{
		$model = AdminModel::firstOrNew(['username' => $admin->getUsername()]);

		return $this->mapper->map($admin, $model);
	}
}
