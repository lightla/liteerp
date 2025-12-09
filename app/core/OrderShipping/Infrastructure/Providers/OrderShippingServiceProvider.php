<?php

namespace Core\Ordershipping\Infrastructure\Providers;

use Core\Ordershipping\Application\UseCases\CheckReadyOrderShipping;
use Core\Ordershipping\Application\UseCases\CreateOrderShipping;
use Illuminate\Support\ServiceProvider;
use Core\Ordershipping\Domain\Repositories\OrderShippingRepositoryInterface;
use Core\Ordershipping\Infrastructure\Repositories\EloquentOrderShippingRepository;
use Core\Ordershipping\Domain\Services\OrderShippingService;
use Core\Ordershipping\Infrastructure\Listeners\OrderShippingListener;
use Core\Ordershipping\Infrastructure\Services\OrderShippingServiceImpl;

class OrderShippingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(OrderShippingRepositoryInterface::class, EloquentOrderShippingRepository::class);
        $this->app->bind(OrderShippingService::class, OrderShippingServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(CreateOrderShipping $createOrderShipping,
        CheckReadyOrderShipping $CheckReadyOrderShipping)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $listener = new OrderShippingListener();
        $listener->handle($createOrderShipping,$CheckReadyOrderShipping);
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('OrderShipping') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('OrderShipping'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('OrderShipping'));
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