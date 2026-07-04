<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @TODO: move to repository layer but for now keep it here for simplicity
 */
class ArticleService
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        // search
        // filtering
        // eager loading
        // sorting
        // pagination
        return Article::query()
            ->with([
                'source',
                'author',
                'categories',
            ])
            ->paginate($filters['per_page'] ?? 15);
    }

    public function findOrFail(int $id): Article
    {
        return Article::query()
            ->with([
                'source',
                'author',
                'categories',
            ])
            ->findOrFail($id);
    }
}