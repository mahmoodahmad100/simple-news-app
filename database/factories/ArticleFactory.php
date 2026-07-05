<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
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
            'author_id' => Author::factory(),
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'external_id' => fake()->uuid(),
            'description' => fake()->text(),
            'content' => fake()->paragraph(),
            'url' => fake()->url(),
            'image_url' => fake()->imageUrl(),
            'published_at' => now(),
        ];
    }
}
