<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_articles(): void
    {
        $source = Source::factory()->create();
        $author = Author::factory()->create();
        $category = Category::factory()->create();

        $article = Article::factory()
            ->for($source)
            ->for($author)
            ->hasAttached($category)
            ->create();

        $response = $this->getJson('/api/v1/articles');

        $response->assertOk()
            ->assertJsonFragment([
                'id' => $article->id,
            ]);
    }

    public function test_it_can_filter_by_title(): void
    {
        Article::factory()->create([
            'title' => 'Unique Test News',
        ]);

        Article::factory()->create([
            'title' => 'Other News',
        ]);

        $response = $this->getJson('/api/v1/articles?title=Test');

        $response->assertOk()
            ->assertJsonFragment([
                'title' => 'Unique Test News',
            ]);
    }

    public function test_it_can_show_single_article(): void
    {
        $article = Article::factory()->create();

        $response = $this->getJson("/api/v1/articles/{$article->id}");

        $response->assertOk()
            ->assertJsonFragment([
                'id' => $article->id,
            ]);
    }
}