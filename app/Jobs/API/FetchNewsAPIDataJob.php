<?php

namespace App\Jobs\API;

use App\Services\Fetch\NewsAPIService;
use App\Services\Model\NewsAPIDBService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchNewsAPIDataJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(NewsAPIDBService $newsAPIDBService): void
    {
        try {
            $newsApiService = new NewsAPIService(env('NEWSAPI_KEY'));
            $latestNews = $newsApiService->fetchLatestNews();
            foreach($latestNews as $category => $value){
                foreach($value['data']['articles'] as $news){
                
                    if($news['title'] == '[Removed]') continue;
    
                    //insert to database
                    $newsAPIDBService->insertNews($news, $category);
                    
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
