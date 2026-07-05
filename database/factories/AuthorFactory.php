<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'source_id' => Source::factory(),
            'external_id' => $this->faker->uuid(),
            'name' => $this->faker->name(),
        ];
    }
}
