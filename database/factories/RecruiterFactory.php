<?php

namespace Database\Factories;

use App\BusinessObjects\Models\Users\Recruiter;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruiterFactory extends Factory
{
	protected $model = Recruiter::class;

	public function definition(): array
	{
		return ['linkedin_profile' => fake()->unique()->url(), 'name' => fake()->name,
			'language' => fake()->languageCode, 'email' => fake()->unique()->safeEmail(),
			'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		];
	}
}
