<?php

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Mapper as UserMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Mapper extends UserMapper
{

    public function map(DTO $dto, Model $admin): Admin
    {
        if (empty($admin->id)) {
            $admin->created_at = now();
        }
        if (!empty($dto->getLanguage())) {
            $admin->language = $dto->getLanguage();
        }
        if (!empty($dto->getPsswd())) {
            $admin->password = Hash::make($dto->getPsswd());
        }

        return $admin;
    }
}
