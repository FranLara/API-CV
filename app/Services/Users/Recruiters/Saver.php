<?php
declare(strict_types = 1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
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

	private function getMappedModel(Recruiter $recruiter): RecruiterModel
	{
		$model = RecruiterModel::firstOrNew(['email' => $recruiter->getEmail()]);

		return $this->mapper->map($recruiter, $model);
	}
}
