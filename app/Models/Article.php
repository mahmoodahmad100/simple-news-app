<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model
{
    protected $fillable = [
        'source_id',
        'author_id',
        'external_id',
        'title',
        'slug',
        'description',
        'content',
        'url',
        'image_url',
        'published_at',
        'hash',
        'metadata',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        return $query->when($term, function ($q) use ($term) {
            $q->where('title', 'ILIKE', "%{$term}%")
              ->orWhere('description', 'ILIKE', "%{$term}%");
        });
    }

    public function scopeForSource(Builder $query, ?int $sourceId): Builder
    {
        return $query->when($sourceId, fn ($q) => $q->where('source_id', $sourceId));
    }

    public function scopeForCategory(Builder $query, ?int $categoryId): Builder
    {
        return $query->when($categoryId, function ($q) use ($categoryId) {
            $q->whereHas('categories', fn ($q2) => $q2->where('categories.id', $categoryId));
        });
    }

    public function scopeForAuthor(Builder $query, ?int $authorId): Builder
    {
        return $query->when($authorId, fn ($q) => $q->where('author_id', $authorId));
    }
}