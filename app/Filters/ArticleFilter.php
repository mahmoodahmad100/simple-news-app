<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ArticleFilter
{
    public function __construct(
        private readonly Builder $query,
        private readonly array $filters
    ) {}

    public function apply(): Builder
    {
        $this->applySearch();
        $this->applySource();
        $this->applyAuthor();
        $this->applyCategory();
        $this->applyDateRange();
        $this->applySorting();

        return $this->query;
    }

    private function applySearch(): void
    {
        if (empty($this->filters['search'])) {
            return;
        }

        $search = $this->filters['search'];

        $this->query->where(function ($q) use ($search) {
            $q->where('title', 'ILIKE', "%{$search}%")
              ->orWhere('description', 'ILIKE', "%{$search}%")
              ->orWhere('content', 'ILIKE', "%{$search}%")
              ->orWhereHas('author', fn ($q) =>
                  $q->where('name', 'ILIKE', "%{$search}%")
              )
              ->orWhereHas('source', fn ($q) =>
                  $q->where('name', 'ILIKE', "%{$search}%")
              );
        });
    }

    private function applySource(): void
    {
        if (!empty($this->filters['source'])) {
            $this->query->where('source_id', $this->filters['source']);
        }
    }

    private function applyAuthor(): void
    {
        if (!empty($this->filters['author'])) {
            $this->query->where('author_id', $this->filters['author']);
        }
    }

    private function applyCategory(): void
    {
        if (!empty($this->filters['category'])) {
            $this->query->whereHas('categories', function ($q) {
                $q->where('categories.id', $this->filters['category']);
            });
        }
    }

    private function applyDateRange(): void
    {
        if (!empty($this->filters['from'])) {
            $this->query->whereDate('published_at', '>=', $this->filters['from']);
        }

        if (!empty($this->filters['to'])) {
            $this->query->whereDate('published_at', '<=', $this->filters['to']);
        }
    }

    private function applySorting(): void
    {
        $sort = $this->filters['sort'] ?? '-published_at';

        match ($sort) {
            'published_at' => $this->query->orderBy('published_at', 'asc'),
            '-published_at' => $this->query->orderBy('published_at', 'desc'),
            'title' => $this->query->orderBy('title', 'asc'),
            '-title' => $this->query->orderBy('title', 'desc'),
            default => $this->query->orderByDesc('published_at'),
        };
    }
}