<?php

declare(strict_types=1);

namespace Database\Factories;

use App\BusinessObjects\Models\Changelog;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChangelogFactory extends Factory
{
    protected $model = Changelog::class;

    public function definition(): array
    {
        return [
            'entity_id'     => fake()->numberBetween(1),
            'type'          => collect($this->model::ENTITY_TYPES)->random(),
            'value_payload' => json_encode([$this->faker->word() => $this->faker->word()]),
        ];
    }
}
