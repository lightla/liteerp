<?php

namespace Core\Inventory\Infrastructure\Providers;

use Core\Inventory\Application\UseCases\OrderItemCompletedUpdate;
use Core\Inventory\Application\UseCases\AdjustmentUpdateInventory;
use Core\Inventory\Application\UseCases\OrderItemCancelledUpdate;
use Core\Inventory\Application\UseCases\UpdateInventoryById;
use Core\Inventory\Application\UseCases\UpdateInventoryByStockMovementIn;
use Illuminate\Support\ServiceProvider;
use Core\Inventory\Domain\Repositories\InventoryRepositoryInterface;
use Core\Inventory\Infrastructure\Repositories\EloquentInventoryRepository;
use Core\Inventory\Domain\Services\InventoryService;
use Core\Inventory\Infrastructure\Listeners\InventoryListener;
use Core\Inventory\Infrastructure\Services\InventoryServiceImpl;

class InventoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(InventoryRepositoryInterface::class, EloquentInventoryRepository::class);
        $this->app->bind(InventoryService::class, InventoryServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(
        UpdateInventoryById $UpdateInventoryById,
        UpdateInventoryByStockMovementIn $UpdateInventoryByStockMovementIn,
        OrderItemCompletedUpdate $OrderItemCompletedUpdate,
        AdjustmentUpdateInventory $AdjustmentUpdateInventory,
        OrderItemCancelledUpdate $OrderItemCancelledUpdate)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $this->loadModuleCommands();
        $listenr = new InventoryListener();
        $listenr->handle(
        $UpdateInventoryById,
        $UpdateInventoryByStockMovementIn,
        $OrderItemCompletedUpdate,
        $AdjustmentUpdateInventory,
        $OrderItemCancelledUpdate);
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('Inventory') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('Inventory'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('Inventory'));
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
                    return $module ? "Core\\{$module}\\Console\\{$class}" : null;
                }, $commandFiles);
                $commandClasses = array_values(array_filter($commandClasses));

                if (!empty($commandClasses)) {
                    $this->commands($commandClasses);
                }
            }
        }
    }
}
