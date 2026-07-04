<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\DTOs\ArticleDTO;
use App\Models\Article;
use App\Models\Author;
use App\Models\Source;

class ArticleIngestionService
{
    public function store(ArticleDTO $dto, Source $source): Article
{
        return DB::transaction(function () use ($dto, $source) {

            $author = $this->resolveAuthor($dto, $source);

            $article = Article::updateOrCreate(
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

            $this->syncCategories($article, $dto);

            return $article;
        });
    }

    private function resolveAuthor(ArticleDTO $dto, Source $source): ?Author
    {
        return $dto->authorName
            ? Author::firstOrCreate([
                'name' => $dto->authorName,
                'source_id' => $source->id,
            ])
            : null;
    }

    private function syncCategories(Article $article, ArticleDTO $dto): void
    {
        if (!empty($dto->categories)) {
            $article->categories()->sync($dto->categories);
        }
    }
}