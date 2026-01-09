<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;
class RunCommandJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $command)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        if(env('ENV') === 'production') {
            Artisan::call($this->command);
        }
    }
}
