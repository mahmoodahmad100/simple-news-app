<?php

namespace App\Services\Providers;

use App\Contracts\NewsProviderInterface;
use App\DTOs\ArticleDTO;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class GuardianProvider implements NewsProviderInterface
{
    public function __construct(
        private readonly HttpFactory $http,
    ) {
    }

    public function fetchArticles(): array
    {
        $response = $this->http
            ->baseUrl(config('services.guardian.base_url'))
            ->acceptJson()
            ->get('/search', [
                'api-key' => config('services.guardian.api_key'),
                'show-fields' => implode(',', [
                    'headline',
                    'trailText',
                    'bodyText',
                    'thumbnail',
                    'byline',
                ]),
                'show-tags' => 'keyword',
                'page-size' => 50,
            ]);

        $response->throw();

        $results = Arr::get($response->json(), 'response.results', []);

        return array_map(
            fn (array $item) => $this->transform($item),
            $results
        );
    }

    public function transform(array $item): ArticleDTO
    {
        return new ArticleDTO(
            title: data_get($item, 'fields.headline', $item['webTitle']),
            description: data_get($item, 'fields.trailText'),
            content: data_get($item, 'fields.bodyText'),
            url: $item['webUrl'],
            imageUrl: data_get($item, 'fields.thumbnail'),
            externalId: $item['id'],
            authorName: data_get($item, 'fields.byline'),
            authorExternalId: data_get($item, 'fields.id'),
            categories: collect($item['tags'] ?? [])
                ->pluck('webTitle')
                ->all(),
            publishedAt: Carbon::parse($item['webPublicationDate']),
            metadata: [
                'section' => $item['sectionName'] ?? null,
                'pillar' => $item['pillarName'] ?? null,
                'type' => $item['type'] ?? null,
            ],
        );
    }
}