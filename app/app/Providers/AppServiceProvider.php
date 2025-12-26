<?php

namespace App\Providers;

use App\Supports\Hooks\HookDispatcher;
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
        $this->app->singleton(HookDispatcher::class);
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
        $this->autoloadModule();
        $this->autoloadExtension();
    }
    protected function autoloadModule()
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
                } catch (\Throwable $e) {
                    logger()->error("Failed to register {$providerClass}: " . $e->getMessage());
                }
            }
        }
    }

    protected function autoloadExtension(): void
    {
        $extensionsPath = base_path('extensions');

        if (! File::exists($extensionsPath)) {
            return;
        }

        foreach (File::directories($extensionsPath) as $extensionPath) {
            $moduleName = basename($extensionPath);
            $configPath = "{$extensionPath}/extension.json";
            $providerPath = "{$extensionPath}/ExtensionServiceProvider.php";

            if (! File::exists($configPath)) {
                continue;
            }
            try {
                $config = json_decode(File::get($configPath), true, 512, JSON_THROW_ON_ERROR);
            } catch (\Throwable $e) {
                logger()->error("Invalid extension.json in {$moduleName}: {$e->getMessage()}");
                continue;
            }

            if (! ($config['status'] ?? false)) {
                continue;
            }

            if (! File::exists($providerPath)) {
                logger()->warning("Extension {$moduleName} enabled but ExtensionServiceProvider.php not found");
                continue;
            }

            $providerClass = "Extensions\\{$moduleName}\\ExtensionServiceProvider";

            try {
                $this->app->register($providerClass);
            } catch (\Throwable $e) {
                logger()->error("Failed to register extension {$moduleName}: {$e->getMessage()}");
            }
        }
    }
}
