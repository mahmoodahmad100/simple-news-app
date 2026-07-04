<?php

namespace App\Factories;

use App\Contracts\NewsProviderInterface;
use App\Enums\NewsProvider;
use InvalidArgumentException;

class NewsProviderFactory
{
    /**
     * @param array<string, NewsProviderInterface> $providers
     */
    public function __construct(
        private readonly array $providers,
    ) {
    }

    public function make(NewsProvider $provider): NewsProviderInterface
    {
        return $this->providers[$provider->value]
            ?? throw new InvalidArgumentException(
                "Unsupported provider [{$provider->value}]"
            );
    }
}