<?php

namespace App\Factories;

use App\Contracts\NewsProviderInterface;
use App\Enums\NewsProvider;
use App\Services\Providers\NewsApiProvider;
use App\Services\Providers\GuardianProvider;
use App\Services\Providers\NyTimesProvider;

class NewsProviderFactory
{
    public static function make(NewsProvider $provider): NewsProviderInterface
    {
        return match ($provider) {
            NewsProvider::NEWS_API => new NewsApiProvider(),
            NewsProvider::GUARDIAN => new GuardianProvider(),
            NewsProvider::NYTIMES => new NyTimesProvider(),
        };
    }
}