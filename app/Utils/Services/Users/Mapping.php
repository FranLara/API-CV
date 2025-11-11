<?php

declare(strict_types=1);

namespace App\Utils\Services\Users;

use App\BusinessObjects\DTOs\Users\User as UserDTO;
use App\BusinessObjects\Models\Users\User;
use Illuminate\Support\Facades\Hash;

trait Mapping
{
    protected function mapUserNotEmptyValues(User $previousUser, UserDTO $dto): User
    {
        $user = clone $previousUser;

        if (!empty($dto->getName())) {
            $user->name = $dto->getName();
        }
        if (!empty($dto->getLanguage())) {
            $user->language = $dto->getLanguage();
        }
        if (!empty($dto->getPsswd())) {
            $user->password = Hash::make($dto->getPsswd());
        }
        if (!empty($dto->getLinkedinProfile())) {
            $user->linkedin_profile = $dto->getLinkedinProfile();
        }

        return $user;
    }
}
