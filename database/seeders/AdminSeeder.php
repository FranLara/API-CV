<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{

	public function run(): void
	{
		DB::table('admins')->truncate();

		DB::table('admins')->insert(['username' => env('SUPER_ADMIN_USERNAME'),
			'password' => Hash::make(env('SUPER_ADMIN_PASSWORD')), 'language' => env('SUPER_ADMIN_LANGUAGE')]);
	}
}
