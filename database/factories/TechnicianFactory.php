<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TechnicianFactory extends Factory
{

	public function definition(): array
	{
		return ['linkedin_profile' => fake()->unique()->url(), 'email' => fake()->unique()->safeEmail(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',];
	}
}
