<?php

namespace App\Services\Providers;

use App\Contracts\NewsProviderInterface;
use App\DTOs\ArticleDTO;

class NyTimesProvider implements NewsProviderInterface
{
    public function fetchArticles(): array
    {
       return [];
    }

    public function transform(array $item): ArticleDTO
    {
        return new ArticleDTO(
            title: $item['title'],
            description: $item['description'] ?? null,
            content: $item['content'] ?? null,
            url: $item['url'] ?? null,
            imageUrl: $item['imageUrl'] ?? null,
            externalId: $item['id'],
            authorName: $item['author'] ?? null,
            category: $item['category'] ?? null,
            publishedAt: $item['publishedAt'] ?? null,
        );
    }
}