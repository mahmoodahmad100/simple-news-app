<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Enums\NewsProvider;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Sample Article 1',
                'content' => 'This is the content of the first sample article.',
                'source_id' => 1,
                'slug' => 'sample-article-1',
                'url' => 'https://example.com/sample-article-1',
            ],
            [
                'title' => 'Sample Article 2',
                'content' => 'This is the content of the second sample article.',
                'source_id' => 2,
                'slug' => 'sample-article-2',
                'url' => 'https://example.com/sample-article-2',
            ],
            [
                'title' => 'Sample Article 3',
                'content' => 'This is the content of the third sample article.',
                'source_id' => 3,
                'slug' => 'sample-article-3',
                'url' => 'https://example.com/sample-article-3',
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['source_id' => $article['source_id'], 'title' => $article['title']],
                $article
            );
        }
    }
}
