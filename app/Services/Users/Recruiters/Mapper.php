<?php

declare(strict_types=1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Mapper as UserMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

readonly class Mapper extends UserMapper
{
    /**
     * @param RecruiterDTO $dto
     * @param Recruiter    $recruiter
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

        if (!empty($dto->getName())) {
            $recruiter->name = $dto->getName();
        }
        if (!empty($dto->getLanguage())) {
            $recruiter->language = $dto->getLanguage();
        }
        if (!empty($dto->getPsswd())) {
            $recruiter->password = Hash::make($dto->getPsswd());
        }
        if (!empty($dto->getLinkedinProfile())) {
            $recruiter->linkedin_profile = $dto->getLinkedinProfile();
        }

        return $recruiter;
    }
}
