<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Source;
use App\Enums\NewsProvider;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            [
                'name' => 'News API',
                'provider' => NewsProvider::NEWS_API->value,
            ],
            [
                'name' => 'The Guardian',
                'provider' => NewsProvider::GUARDIAN->value,
            ],
            [
                'name' => 'New York Times',
                'provider' => NewsProvider::NYTIMES->value,
            ],
        ];

        foreach ($sources as $source) {
            Source::updateOrCreate(
                ['provider' => $source['provider']],
                $source
            );
        }
    }
}
