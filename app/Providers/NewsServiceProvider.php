<?php

namespace App\Providers;

use App\Enums\NewsProvider;
use App\Factories\NewsProviderFactory;
use App\Services\Providers\GuardianProvider;
use App\Services\Providers\NewsApiProvider;
use App\Services\Providers\NyTimesProvider;
use Illuminate\Support\ServiceProvider;

class NewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(NewsProviderFactory::class, function ($app) {
            return new NewsProviderFactory([
                NewsProvider::NEWS_API->value => $app->make(NewsApiProvider::class),

                NewsProvider::GUARDIAN->value => $app->make(GuardianProvider::class),

                NewsProvider::NYTIMES->value => $app->make(NyTimesProvider::class),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}