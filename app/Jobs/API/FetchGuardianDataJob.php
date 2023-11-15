<?php

namespace App\Jobs\API;

use App\Services\Fetch\GuardianAPIService;
use App\Services\Model\GuardianDBService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchGuardianDataJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(GuardianDBService $guardianDBService): void
    {
        try {
            $guardianService = new GuardianAPIService(env('GUARDIANAPI_KEY'));
            $latestNews = $guardianService->fetchLatestNews();
            foreach($latestNews['data']['response']['results'] as $news) {
                $guardianDBService->insertNews($news);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
