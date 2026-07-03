<?php

namespace App\DTOs;

class ArticleDTO
{
    public function __construct(
        public string $title,
        public ?string $description,
        public ?string $content,
        public ?string $url,
        public ?string $imageUrl,
        public ?string $externalId,
        public ?string $authorName,
        public ?string $category,
        public ?string $publishedAt,
    ) {}
}