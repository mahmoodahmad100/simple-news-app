<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\DTOs\ArticleDTO;
use App\Models\Article;
use App\Models\Author;
use App\Models\Source;
use App\Models\Category;

class ArticleIngestionService
{
    public function store(ArticleDTO $dto, Source $source): Article
{
        return DB::transaction(function () use ($dto, $source) {

            $author = $this->resolveAuthor($dto, $source);
            $slug = Str::slug($dto->title . '-' . $source->id);

            $article = Article::updateOrCreate(
                [
                    'slug' => $slug,
                    'source_id' => $source->id,
                ],
                [
                    'slug' => $slug,
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
        if (empty($dto->categories)) {
            return;
        }

        $categoryIds = collect($dto->categories)
            ->filter()
            ->map(function ($name) use ($article) {
                return Category::firstOrCreate([
                    'name' => $name,
                    'slug' => Str::slug($name)
                ])->id;
            })
            ->values()
            ->all();

        $article->categories()->sync($categoryIds);
    }
}