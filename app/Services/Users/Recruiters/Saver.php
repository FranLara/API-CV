<?php
declare(strict_types = 1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\Services\Users\Saver as UserSaver;
use Override;

class Saver extends UserSaver
{

	public function __construct(Mapper $mapper)
	{
		$this->mapper = $mapper;
	}

	#[Override]
    public function save(DTO $recruiter): bool
	{
		$model = $this->getMappedModel($recruiter);

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
