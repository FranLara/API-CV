<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('admins')->truncate();

        DB::table('admins')->insert(
            [
                'id'       => Str::orderedUuid(),
                'username' => config('auth.super_admin.username'),
                'language' => config('auth.super_admin.language'),
                'password' => Hash::make(config('auth.super_admin.psswd')),
            ]
        );
    }
}
