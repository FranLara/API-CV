<?php

declare(strict_types=1);

namespace App\Services\Users\Technicians;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Technician as TechnicianDTO;
use App\BusinessObjects\Models\Users\Technician;
use App\Services\Users\Mapper as UserMapper;
use App\Utils\Services\Users\Mapping as MappingUtils;
use Illuminate\Database\Eloquent\Model;

class Mapper extends UserMapper
{
    use MappingUtils;

    /**
     * @param  TechnicianDTO  $dto
     * @param  Technician  $technician
     */
    public function map(DTO $dto, Model $technician): Technician
    {
        if (empty($technician->id)) {
            $technician->created_at = now();
        }

        return $this->mapNotEmptyValues($technician, $dto);
    }

    private function mapNotEmptyValues(Technician $previousTechnician, TechnicianDTO $dto): Technician
    {
        $technician = clone $previousTechnician;

        /** @var Technician $technician */
        $technician = $this->mapUserNotEmptyValues($technician, $dto);

        if (!empty($dto->getGithubProfile())) {
            $technician->github_profile = $dto->getGithubProfile();
        }

        return $technician;
    }
}
