<?php

namespace Core\InvoiceOut\Infrastructure\Providers;

use Core\InvoiceOut\Application\UseCases\CreateInvoiceOut;
use Core\InvoiceOut\Application\UseCases\UnapproveInvoiceOutByOrderCancelled;
use Illuminate\Support\ServiceProvider;
use Core\InvoiceOut\Domain\Repositories\InvoiceOutRepositoryInterface;
use Core\InvoiceOut\Infrastructure\Repositories\EloquentInvoiceOutRepository;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Core\InvoiceOut\Infrastructure\Listeners\InvoiceOutListener;
use Core\InvoiceOut\Infrastructure\Services\InvoiceOutServiceImpl;

class InvoiceOutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(InvoiceOutRepositoryInterface::class, EloquentInvoiceOutRepository::class);
        $this->app->bind(InvoiceOutService::class, InvoiceOutServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(CreateInvoiceOut $createInvoiceOut,
    UnapproveInvoiceOutByOrderCancelled $UnapproveInvoiceOutByOrderCancelled)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $listener = new InvoiceOutListener();
        $listener->handle($createInvoiceOut,$UnapproveInvoiceOutByOrderCancelled);
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('InvoiceOuts') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('InvoiceOuts'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('InvoiceOuts'));
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