<?php

namespace App\Console\Commands;

use Core\Overview\Application\UseCases\CreateOverview;
use Illuminate\Console\Command;

class OverviewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:overview';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CreateOverview $CreateOverview)
    {
        //
        $CreateOverview->handle();
        $this->info("Done!");
    }
}
