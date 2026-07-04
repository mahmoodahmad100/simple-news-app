<?php

namespace App\Services;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Article;

class ArticleService
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articleRepository,
    ) {}

    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->articleRepository->paginate($filters);
    }

    public function findOrFail(int $id): Article
    {
        return $this->articleRepository->findOrFail($id);
    }
}