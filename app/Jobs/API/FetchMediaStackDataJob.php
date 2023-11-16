<?php

namespace App\Jobs\API;

use App\Services\Fetch\MediaStackAPIService;
use App\Services\Model\MediaStackDBService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchMediaStackDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $mediaStackAPIService, $mediaStackDBService;

    public function __construct(MediaStackAPIService $mediaStackAPIService, MediaStackDBService $mediaStackDBService) {
        $this->mediaStackAPIService = $mediaStackAPIService;
        $this->mediaStackDBService  = $mediaStackDBService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->mediaStackAPIService->setCredentials(config("api_creadentials.mediastack_api_key"));
            $latestNews = $this->mediaStackAPIService->fetchLatestNews();
            foreach($latestNews['data']['data'] as $news) {
                $this->mediaStackDBService->insertNews($news);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
