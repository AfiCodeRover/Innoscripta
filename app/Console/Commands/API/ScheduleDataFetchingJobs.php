<?php

namespace App\Console\Commands\API;

use App\Jobs\API\FetchGuardianDataJob;
use App\Jobs\API\FetchMediaStackDataJob;
use App\Jobs\API\FetchNewsAPIDataJob;
use App\Services\Fetch\GuardianAPIService;
use App\Services\Fetch\MediaStackAPIService;
use App\Services\Fetch\NewsAPIService;
use App\Services\Model\GuardianDBService;
use App\Services\Model\MediaStackDBService;
use App\Services\Model\NewsAPIDBService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class ScheduleDataFetchingJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dispatch:fetching-data-jobs';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule data fetching jobs for NewsAPI, the Guardian API, and Nediastack API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Bus::chain([
            new FetchNewsAPIDataJob(new NewsAPIService, new NewsAPIDBService),
            new FetchGuardianDataJob(new GuardianAPIService, new GuardianDBService),
            new FetchMediaStackDataJob(new MediaStackAPIService, new MediaStackDBService)
        ])->dispatch();
        $this->info('The jobs dispatched successfully.');
    }
}
