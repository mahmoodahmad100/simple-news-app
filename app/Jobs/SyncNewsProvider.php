<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\Tries;
use Illuminate\Queue\Attributes\Timeout;
use Illuminate\Queue\Attributes\Backoff;
use Illuminate\Support\Facades\Log;
use App\Enums\NewsProvider;
use App\Services\NewsSyncService;
use App\Models\Source;
use Throwable;

#[Tries(3)]
#[Timeout(120)]
#[Backoff([60, 300, 600])]
class SyncNewsProvider implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public NewsProvider $provider)
    {
        $this->onQueue('sync-news');
    }

    /**
     * Execute the job.
     */
    public function handle(NewsSyncService $newsSyncService): void
    {
        $source = Source::where('provider', $this->provider->value)->firstOrFail();

        $newsSyncService->sync($source);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error('News synchronization failed.', [
            'provider' => $this->provider->value,
            'message' => $exception?->getMessage(),
            'trace' => $exception?->getTraceAsString(),
        ]);
        // Send user notification of failure, etc...
    }
}
