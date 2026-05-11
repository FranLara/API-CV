<?php

declare(strict_types=1);

namespace App\Services\Users\Admins;

use App\BusinessObjects\DTOs\DTO;
use App\BusinessObjects\DTOs\Users\Admin as AdminDTO;
use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Mapper as UserMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Mapper extends UserMapper
{
    /**
     * @param  AdminDTO  $dto
     * @param  Admin  $admin
     */
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
