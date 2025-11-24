<?php

declare(strict_types=1);

namespace App\Services\Users\Technicians;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Technician;
use App\BusinessObjects\Models\Users\Technician as TechnicianModel;
use App\Services\Mapper;
use App\Services\Users\Saver as UserSaver;

class Saver extends UserSaver
{
    public function __construct(private readonly Mapper $mapper)
    {
    }

    public function save(DTO $technician): bool
    {
        $model = $this->getMappedModel($technician);

        if ($model->isDirty()) {
            return $model->save();
        }

        return true;
    }

    private function getMappedModel(Technician $technician): TechnicianModel
    {
        $model = TechnicianModel::firstOrNew(['email' => $technician->getEmail()]);

        return $this->mapper->map($technician, $model);
    }
}
