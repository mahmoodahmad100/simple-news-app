<?php

namespace App\DTOs;

use Carbon\Carbon;
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
        public ?string $authorExternalId,

        public array $categories = [],

        public ?Carbon $publishedAt = null,

        public array $metadata = [],
    ) {}
}