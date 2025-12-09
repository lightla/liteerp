<?php

namespace Core\OrderItem\Infrastructure\Providers;

use Core\OrderItem\Application\UseCases\CancelledOrderItem;
use Core\OrderItem\Application\UseCases\CheckExistsOrderItem;
use Core\OrderItem\Application\UseCases\CompletedOrderItem;
use Core\OrderItem\Application\UseCases\GetSummaryOrderItem;
use Illuminate\Support\ServiceProvider;
use Core\OrderItem\Domain\Repositories\OrderItemRepositoryInterface;
use Core\OrderItem\Infrastructure\Repositories\EloquentOrderItemRepository;
use Core\OrderItem\Domain\Services\OrderItemService;
use Core\OrderItem\Infrastructure\Listeners\OrderItemListener;
use Core\OrderItem\Infrastructure\Services\OrderItemServiceImpl;

class OrderItemServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderItemRepositoryInterface::class, EloquentOrderItemRepository::class);
        $this->app->bind(OrderItemService::class, OrderItemServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(CompletedOrderItem $CompletedOrderItem,
        CancelledOrderItem $CancelledOrderItem,
          CheckExistsOrderItem $CheckExistsOrderItem,
          GetSummaryOrderItem $getSummaryOrderItem)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $listener = new OrderItemListener();
        $listener->handle($CompletedOrderItem,
        $CancelledOrderItem,
        $CheckExistsOrderItem,
        $getSummaryOrderItem);
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('OrderItems') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('OrderItems'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('OrderItems'));
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
}