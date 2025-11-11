<?php

declare(strict_types=1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Mapper as UserMapper;
use App\Utils\Services\Users\Mapping as MappingUtils;
use Illuminate\Database\Eloquent\Model;

class Mapper extends UserMapper
{
    use MappingUtils;

    /**
     * @param  RecruiterDTO  $dto
     * @param  Recruiter  $recruiter
     */
    public function map(DTO $dto, Model $recruiter): Recruiter
    {
        if (empty($recruiter->id)) {
            $recruiter->created_at = now();
        }

        return $this->mapNotEmptyValues($recruiter, $dto);
    }

    private function mapNotEmptyValues(Recruiter $previousRecruiter, RecruiterDTO $dto): Recruiter
    {
        $recruiter = clone $previousRecruiter;

        return $this->mapUserNotEmptyValues($recruiter, $dto);
    }
}
