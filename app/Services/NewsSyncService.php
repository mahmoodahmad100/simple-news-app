<?php

namespace App\Services;

use App\Factories\NewsProviderFactory;
use App\Models\Source;
use Throwable;

class NewsSyncService
{
    public function __construct(
        private readonly NewsProviderFactory $providerFactory,
        private readonly ArticleIngestionService $articleIngestionService,
    ) {
    }

    public function sync(Source $source): void
    {
        $provider = $this->providerFactory->make($source->provider);

        foreach ($provider->fetchArticles() as $item) {
            try {
                $dto = $provider->transform($item);

                $this->articleIngestionService->store($dto, $source);
            } catch (Throwable $exception) {
                report($exception);
            }
        }
    }
}