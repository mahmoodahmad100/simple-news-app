<?php

namespace App\Services\Providers;

use App\Contracts\NewsProviderInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class NewsApiProvider implements NewsProviderInterface
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    public function fetchArticles(): array
    {
        $response = $this->http
            ->baseUrl(config('services.newsapi.base_url'))
            ->acceptJson()
            ->get('/top-headlines', [
                'apiKey' => config('services.newsapi.api_key'),
                'country' => 'us', // adjust or make dynamic later
                'pageSize' => 50,
            ]);

        $response->throw();

        $articles = Arr::get($response->json(), 'articles', []);

        return array_map(
            fn (array $item) => $this->transform($item),
            $articles
        );
    }

    public function transform(array $item): ArticleDTO
    {
        return new ArticleDTO(
            title: $item['title'],
            description: $item['description'] ?? null,
            content: $item['content'] ?? null,
            url: $item['url'] ?? null,
            imageUrl: $item['urlToImage'] ?? null,
            externalId: null,
            authorName: $item['author'] ?? null,
            authorExternalId: null,
            categories: [], // NewsAPI does not reliably provide categories in /top-headlines
            publishedAt: Carbon::parse($item['publishedAt']) ?? null,
            metadata: [
                'source' => $item['source']['name'] ?? null,
            ],
        );
    }
}