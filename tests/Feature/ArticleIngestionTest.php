<?php

namespace Tests\Feature;

use App\DTOs\ArticleDTO;
use App\Models\Source;
use App\Services\ArticleIngestionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleIngestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_article_from_dto(): void
    {
        $source = Source::factory()->create();

        $dto = new ArticleDTO(
            title: 'Test Article',
            description: 'Desc',
            content: 'Content',
            url: 'https://example.com',
            imageUrl: null,
            externalId: 'ext-123',
            authorName: 'John Doe',
            authorExternalId: null,
            categories: ['Tech'],
            publishedAt: now(),
            metadata: [],
        );

        $service = app(ArticleIngestionService::class);

        $service->store($dto, $source);

        $this->assertDatabaseHas('articles', [
            'external_id' => 'ext-123',
            'title' => 'Test Article',
            'source_id' => $source->id,
        ]);
    }

    public function test_it_does_not_duplicate_articles(): void
    {
        $source = Source::factory()->create();

        $dto = new ArticleDTO(
            title: 'Test Article',
            description: 'Desc',
            content: 'Content',
            url: 'https://example.com',
            imageUrl: null,
            externalId: 'ext-123',
            authorName: 'John Doe',
            authorExternalId: null,
            categories: [],
            publishedAt: now(),
            metadata: [],
        );

        $service = app(ArticleIngestionService::class);

        $service->store($dto, $source);
        $service->store($dto, $source);

        $this->assertDatabaseCount('articles', 1);
    }
}