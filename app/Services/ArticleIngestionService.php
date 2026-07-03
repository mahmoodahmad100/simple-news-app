<?php

namespace App\Services;

use App\DTOs\ArticleDTO;
use App\Models\Article;
use App\Models\Author;
use App\Models\Source;

class ArticleIngestionService
{
    public function store(ArticleDTO $dto, Source $source): void
    {
        $author = $dto->authorName
            ? Author::firstOrCreate([
                'name' => $dto->authorName,
                'source_id' => $source->id,
            ])
            : null;

        Article::updateOrCreate(
            [
                'external_id' => $dto->externalId,
                'source_id' => $source->id,
            ],
            [
                'author_id' => $author?->id,
                'title' => $dto->title,
                'description' => $dto->description,
                'content' => $dto->content,
                'url' => $dto->url,
                'image_url' => $dto->imageUrl,
                'published_at' => $dto->publishedAt,
            ]
        );
    }
}