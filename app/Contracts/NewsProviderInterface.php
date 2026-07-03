<?php

namespace App\Contracts;

use App\DTOs\ArticleDTO;

interface NewsProviderInterface
{
    public function fetchArticles(): array;

    public function transform(array $item): ArticleDTO;
}