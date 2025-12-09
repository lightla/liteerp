<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerCoreModules();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
    protected function registerCoreModules(): void
    {
        $corePath = base_path('core');
        if (!File::exists($corePath)) {
            return;
        }
        $modules = File::directories($corePath);

        foreach ($modules as $modulePath) {
            $moduleName = basename($modulePath);
            $providerPath = "{$modulePath}/Infrastructure/Providers/{$moduleName}ServiceProvider.php";

            if (File::exists($providerPath)) {
                $providerClass = "Core\\{$moduleName}\\Infrastructure\\Providers\\{$moduleName}ServiceProvider";

                try {
                    $this->app->register($providerClass);
                    //logger()->info("✅ Loaded module provider: {$providerClass}");
                } catch (\Throwable $e) {
                    //logger()->error("⚠️ Failed to register {$providerClass}: " . $e->getMessage());
                }
            }
        }
    }
}
