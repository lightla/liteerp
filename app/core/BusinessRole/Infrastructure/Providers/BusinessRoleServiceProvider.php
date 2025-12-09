<?php

namespace Core\BusinessRole\Infrastructure\Providers;

use Core\BusinessRole\Application\UseCases\CheckPermissionBusinessRole;
use Core\BusinessRole\Application\UseCases\CreateBusinessRole;
use Core\BusinessRole\Application\UseCases\UpdateBusinessRole;
use Core\BusinessRole\Domain\Services\BusinessTokenService;
use Core\BusinessRole\Infrastructure\Services\BusinessTokenServiceImpl;
use Illuminate\Support\ServiceProvider;
use Core\BusinessRole\Domain\Repositories\BusinessRoleRepositoryInterface;
use Core\BusinessRole\Infrastructure\Repositories\EloquentBusinessRoleRepository;
use Core\BusinessRole\Domain\Services\BusinessRoleService;
use Core\BusinessRole\Infrastructure\Listeners\BusinessRoleListener;
use Core\BusinessRole\Infrastructure\Services\BusinessRoleServiceImpl;

class BusinessRoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(BusinessRoleRepositoryInterface::class, EloquentBusinessRoleRepository::class);
        $this->app->bind(BusinessRoleService::class, BusinessRoleServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(CheckPermissionBusinessRole $checkPermission, 
    CreateBusinessRole $createBusinessRole,
    UpdateBusinessRole $updateBusinessRole)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $event = new BusinessRoleListener($checkPermission,
        $createBusinessRole,
        $updateBusinessRole);
        $event->handle();
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('BusinessRole') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('BusinessRole'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('BusinessRole'));
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