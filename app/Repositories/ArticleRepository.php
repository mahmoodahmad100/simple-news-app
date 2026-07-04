<?php

namespace App\Repositories;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Models\Article;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function paginate(array $filters): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        /**
         * @TODO: this is a simple implementation for now just for testing the flow (controller -> service -> repository).
         */
        $query = Article::query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['author'])) {
            $query->where('author', 'like', '%' . $filters['author'] . '%');
        }

        return $query->paginate(10);
    }

    public function findOrFail(int $id): Article
    {
        return Article::findOrFail($id);
    }
}