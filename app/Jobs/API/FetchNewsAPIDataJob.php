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

    private $newsApiService, $newsAPIDBService;

    public function __construct(NewsAPIService $newsApiService, NewsAPIDBService $newsAPIDBService) {
        $this->newsApiService = $newsApiService;
        $this->newsAPIDBService  = $newsAPIDBService;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->newsApiService->setCredentials(config("api_creadentials.news_api_key"));
            $latestNews = $this->newsApiService->fetchLatestNews();
            foreach($latestNews as $category => $value){
                foreach($value['data']['articles'] as $news){
                
                    if($news['title'] == '[Removed]') continue;
    
                    //insert to database
                    $this->newsAPIDBService->insertNews($news, $category);
                    
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
