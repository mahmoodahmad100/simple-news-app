<?php

namespace App\Repositories;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Models\Article;
use App\Filters\ArticleFilter;

class ArticleRepository implements ArticleRepositoryInterface
{
    private const RELATIONS = [
        'source',
        'author',
        'categories',
    ];

    public function paginate(array $filters): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Article::query()->with(self::RELATIONS);

        (new ArticleFilter($query, $filters))->apply();

        return $query->paginate($filters['per_page'] ?? 15);
    }

    public function findOrFail(int $id): Article
    {
        return Article::query()
            ->with(self::RELATIONS)
            ->findOrFail($id);
    }
}