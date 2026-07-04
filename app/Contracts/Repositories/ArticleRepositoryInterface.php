<?php

namespace App\Contracts\Repositories;

use App\Models\Article;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function paginate(array $filters): LengthAwarePaginator;

    public function findOrFail(int $id): Article;
}