<?php

namespace Core\Extension\Infrastructure\Supports;

use App\Exceptions\BadException;
use Core\Extension\Application\DTOs\ExtensionInstallPlan;
use Core\Extension\Domain\Supports\ExtensionInstallExecutorInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ExtensionInstallExecutor implements ExtensionInstallExecutorInterface
{
    private $allowCommands = [
        "app:npmbuild"
    ];
    public function execute(ExtensionInstallPlan $plan): void
    {

        $this->runMigrations($plan);
        $this->runCommands($plan);
        $this->log($plan);
    }
    private function runMigrations(ExtensionInstallPlan $plan): void
    {
        foreach ($plan->migrations as $migration) {
            $filePath = base_path("extensions/". $plan->directory ."/databases/migrations/". $migration);
            if(file_exists($filePath)) {
               Artisan::call($filePath);
            } else {
                throw new BadException(__("Not found migration file :" . $migration));
            }
        }
    }
    private function runCommands(ExtensionInstallPlan $plan): void
    {
        foreach ($plan->commands as $command) {
            if (in_array($command['name'], $this->allowCommands)) {
                Log::info('Run:'. $command['name']);
                Artisan::call($command['name']);
            } else {
                throw new BadException(__("Command register invalid"));
            }
        }
    }
    private function log(ExtensionInstallPlan $plan): void
    {
        Log::info(json_encode($plan));
    }
}
