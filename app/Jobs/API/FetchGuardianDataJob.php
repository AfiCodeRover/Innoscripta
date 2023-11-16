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

    private $guardianAPIService, $guardianDBService;

    public function __construct(GuardianAPIService $guardianAPIService, GuardianDBService $guardianDBService) {
        $this->guardianAPIService = $guardianAPIService;
        $this->guardianDBService  = $guardianDBService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->guardianAPIService->setCredentials(config("api_creadentials.guardian_api_key"));
            $latestNews = $this->guardianAPIService->fetchLatestNews();
            foreach($latestNews['data']['response']['results'] as $news) {
                $this->guardianDBService->insertNews($news);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
