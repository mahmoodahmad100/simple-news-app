<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Enums\NewsProvider;
use App\Jobs\SyncNewsProvider;

#[Signature('news:sync')]
#[Description('Sync News Command')]
class SyncNewsCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        foreach (NewsProvider::cases() as $provider) {
            SyncNewsProvider::dispatch($provider);
        }

        $this->info('News synchronization jobs dispatched.');
    }
}
