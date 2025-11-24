<?php

declare(strict_types=1);

namespace Database\Factories;

use App\BusinessObjects\Models\Users\Recruiter;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruiterFactory extends Factory
{
    protected $model = Recruiter::class;

    public function definition(): array
    {
        return [
            'name'             => fake()->name,
            'language'         => fake()->languageCode,
            'linkedin_profile' => fake()->unique()->url(),
            'email'            => fake()->unique()->safeEmail(),
            'password'         => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ];
    }
}
