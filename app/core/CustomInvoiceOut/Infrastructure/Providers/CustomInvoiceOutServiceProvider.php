<?php

namespace Core\CustomInvoiceOut\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Core\CustomInvoiceOut\Domain\Repositories\CustomInvoiceOutRepositoryInterface;
use Core\CustomInvoiceOut\Infrastructure\Repositories\EloquentCustomInvoiceOutRepository;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Infrastructure\Services\CustomInvoiceOutServiceImpl;

class CustomInvoiceOutServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CustomInvoiceOutRepositoryInterface::class, EloquentCustomInvoiceOutRepository::class);
        $this->app->bind(CustomInvoiceOutService::class, CustomInvoiceOutServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot()
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('CustomInvoiceOut') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('CustomInvoiceOut'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('CustomInvoiceOut'));
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