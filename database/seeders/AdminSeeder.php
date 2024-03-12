<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{

	public function run(): void
	{
		DB::table('admins')->truncate();

		DB::table('admins')->insert(['username' => env('SUPER_ADMIN_USERNAME'),
			'password' => env('SUPER_ADMIN_PASSWORD'), 'language' => env('SUPER_ADMIN_LANGUAGE')]);
	}
}
