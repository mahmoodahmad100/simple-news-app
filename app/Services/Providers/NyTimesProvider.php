<?php

namespace App\Services\Providers;

use App\Contracts\NewsProviderInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class NyTimesProvider implements NewsProviderInterface
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    public function fetchArticles(): array
    {
        $response = $this->http
            ->baseUrl(config('services.nytimes.base_url'))
            ->acceptJson()
            ->get('/topstories/v2/home.json', [
                'api-key' => config('services.nytimes.api_key'),
            ]);

        $response->throw();

        $results = Arr::get($response->json(), 'results', []);

        return array_map(
            fn (array $item) => $this->transform($item),
            $results
        );
    }

    public function transform(array $item): ArticleDTO
    {
        return new ArticleDTO(
            title: $item['title'],
            description: $item['abstract'] ?? null,
            content: $item['lead_paragraph'] ?? ($item['abstract'] ?? null),
            url: $item['url'] ?? null,
            imageUrl: $this->extractImage($item),
            externalId: $item['uri'] ?? $item['url'],
            authorName: $item['byline'] ?? null,
            authorExternalId: null,
            categories: $item['des_facet'] ?? [],
            publishedAt: $item['published_date'] ? Carbon::parse($item['published_date']) : null,
            metadata: [
                'section' => $item['section'] ?? null,
                'subsection' => $item['subsection'] ?? null,
                'source' => 'nytimes',
                'multimedia_count' => isset($item['multimedia']) ? count($item['multimedia']) : 0,
            ],
        );
    }

    private function extractImage(array $item): ?string
    {
        // NYTimes provides multiple images in "multimedia"
        if (!empty($item['multimedia']) && is_array($item['multimedia'])) {
            foreach ($item['multimedia'] as $media) {
                if (($media['format'] ?? null) === 'superJumbo') {
                    return $media['url'] ?? null;
                }
            }

            // fallback: first image
            return $item['multimedia'][0]['url'] ?? null;
        }

        return null;
    }
}