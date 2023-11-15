<?php

namespace App\Console\Commands\API;

use App\Jobs\API\FetchNewsAPIDataJob;
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
            new FetchNewsAPIDataJob(),
        ])->dispatch();
        $this->info('The jobs dispatched successfully.');
    }
}
