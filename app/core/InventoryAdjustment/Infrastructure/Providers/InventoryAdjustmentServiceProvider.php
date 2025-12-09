<?php

namespace Core\InventoryAdjustment\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Core\InventoryAdjustment\Domain\Repositories\InventoryAdjustmentRepositoryInterface;
use Core\InventoryAdjustment\Infrastructure\Repositories\EloquentInventoryAdjustmentRepository;
use Core\InventoryAdjustment\Domain\Services\InventoryAdjustmentService;
use Core\InventoryAdjustment\Infrastructure\Services\InventoryAdjustmentServiceImpl;

class InventoryAdjustmentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(InventoryAdjustmentRepositoryInterface::class, EloquentInventoryAdjustmentRepository::class);
        $this->app->bind(InventoryAdjustmentService::class, InventoryAdjustmentServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot()
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('InventoryAdjustment') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('InventoryAdjustment'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('InventoryAdjustment'));
        }
    }

    protected function loadModuleRoutes(): void
    {
        $routePath = __DIR__ . '/../routes';
        if (file_exists("$routePath/api.php")) {
            $this->loadRoutesFrom("$routePath/api.php");
        }
        if (file_exists("$routePath/web.php")) {
            $this->loadRoutesFrom("$routePath/web.php");
        }
    }
    protected function loadModuleCommands(): void
    {

        if (is_dir(base_path('core'))) {
            $commandFiles = glob(base_path('core') . '/*/Console/*.php');

            if (!empty($commandFiles)) {
                foreach ($commandFiles as $file) {
                    require_once $file;
                }

                $commandClasses = array_map(function ($file) {
                    $class = basename($file, '.php');
                    $parts = explode(DIRECTORY_SEPARATOR, $file);
                    $moduleIndex = array_search('core', $parts);
                    $module = isset($parts[$moduleIndex + 1]) ? $parts[$moduleIndex + 1] : null;
                    return $module ? "Core\{$module}\Console\{$class}" : null;
                }, $commandFiles);

                $commandClasses = array_values(array_filter($commandClasses));

                if (!empty($commandClasses)) {
                    $this->commands($commandClasses);
                }
            }
        }
    }
}