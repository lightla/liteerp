<?php

namespace Core\ProductAttributes\Infrastructure\Providers;

use Core\ProductAttributes\Application\UseCases\CreateProductAttribute;
use Illuminate\Support\ServiceProvider;
use Core\ProductAttributes\Domain\Repositories\ProductAttributeRepositoryInterface;
use Core\ProductAttributes\Infrastructure\Repositories\EloquentProductAttributeRepository;
use Core\ProductAttributes\Domain\Services\ProductAttributeService;
use Core\ProductAttributes\Infrastructure\Listeners\ProductAttributesListener;
use Core\ProductAttributes\Infrastructure\Services\ProductAttributeServiceImpl;

class ProductAttributesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductAttributeRepositoryInterface::class, EloquentProductAttributeRepository::class);
        $this->app->bind(ProductAttributeService::class, ProductAttributeServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(CreateProductAttribute $CreateProductAttribute)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $listener = new ProductAttributesListener();
        $listener->handle($CreateProductAttribute);
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('ProductAttributes') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('ProductAttributes'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('ProductAttributes'));
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