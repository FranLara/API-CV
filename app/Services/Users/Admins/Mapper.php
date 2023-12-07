<?php

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Mapper as UserMapper;
use Illuminate\Support\Facades\Hash;

class Mapper extends UserMapper
{

    public function map(AdminDTO $dto, Admin $admin): Admin
    {
        if (!empty($dto->getIdentifier())) {
            $admin->id = $dto->getIdentifier();
        }
        if (!empty($dto->getLanguage())) {
            $admin->language = $dto->getLanguage();
        }
        if (!empty($dto->getUsername())) {
            $admin->username = $dto->getUsername();
        }
        if (!empty($dto->getPsswd())) {
            $admin->password = Hash::make($dto->getPsswd());
        }

        return $admin;
    }
}
