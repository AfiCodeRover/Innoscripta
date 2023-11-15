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


    /**
     * Execute the job.
     */
    public function handle(MediaStackDBService $mediaStackDBService): void
    {
        try {
            $mediastackService = new MediaStackAPIService(env('MEDIASTACKAPI_KEY'));
            $latestNews = $mediastackService->fetchLatestNews();
            foreach($latestNews['data']['data'] as $news) {
                $mediaStackDBService->insertNews($news);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
