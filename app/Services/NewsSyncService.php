<?php

namespace App\Services;

use App\Factories\NewsProviderFactory;
use App\Models\Source;

class NewsSyncService
{
    public function sync(Source $source): void
    {
        $provider = NewsProviderFactory::make($source->provider);

        $articles = $provider->fetchArticles();

        foreach ($articles as $item) {
            $dto = $provider->transform($item);

            app(ArticleIngestionService::class)->store($dto, $source);
        }
    }
}