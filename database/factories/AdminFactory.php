<?php

namespace Database\Factories;

use App\BusinessObjects\Models\Users\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
	protected $model = Admin::class;

	public function definition(): array
	{
		return ['username' => fake()->unique()->userName(), 'language' => fake()->languageCode,
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		];
	}
}
