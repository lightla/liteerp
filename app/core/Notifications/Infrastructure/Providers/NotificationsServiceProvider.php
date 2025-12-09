<?php

namespace Core\Notifications\Infrastructure\Providers;

use Core\Notifications\Application\UseCases\CreateNotification;
use Illuminate\Support\ServiceProvider;
use Core\Notifications\Domain\Repositories\NotificationRepositoryInterface;
use Core\Notifications\Infrastructure\Repositories\EloquentNotificationRepository;
use Core\Notifications\Domain\Services\NotificationDBService;
use Core\Notifications\Infrastructure\Listeners\NotificationWrite;
use Core\Notifications\Infrastructure\Services\NotificationDBServiceImpl;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class NotificationsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(NotificationRepositoryInterface::class, EloquentNotificationRepository::class);
        $this->app->bind(NotificationDBService::class, NotificationDBServiceImpl::class);
        $this->mergeModuleConfig();
    }

    public function boot(CreateNotification $CreateNotification)
    {
        $this->loadModuleRoutes();
        $this->loadModuleTranslations();
        $listener = new NotificationWrite();
        $listener->handle($CreateNotification);
    }

    protected function mergeModuleConfig(): void
    {
        $path = __DIR__ . '/../config/' . strtolower('Notifications') . '.php';
        if (file_exists($path)) {
            $this->mergeConfigFrom($path, strtolower('Notifications'));
        }
    }

    protected function loadModuleTranslations(): void
    {
        $langPath = __DIR__ . '/../lang';
        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, strtolower('Notifications'));
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
