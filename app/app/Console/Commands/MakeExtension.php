<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;

class MakeExtension extends Command
{
    protected $signature = 'make:extension {name}';
    protected $description = 'Generate a new LiteERP extension skeleton';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $basePath = base_path("extensions/{$name}");

        $fs = new Filesystem();

        if ($fs->exists($basePath)) {
            $this->error("Extension {$name} already exists.");
            return Command::FAILURE;
        }

        $this->createDirectories($fs, $basePath);
        $this->createFiles($fs, $basePath, $name);

        $this->info("Extension {$name} generated successfully.");
        return Command::SUCCESS;
    }

    protected function createDirectories(Filesystem $fs, string $base)
    {
        $dirs = [
            '',
            'Http/Controllers',
            'Models',
            'Hooks',
            'Database/Migrations',
            'Routes',
            'Config',
        ];

        foreach ($dirs as $dir) {
            $fs->makeDirectory("{$base}/{$dir}", 0755, true);
        }
    }

    protected function createFiles(Filesystem $fs, string $base, string $name)
    {
        $namespace = "Extensions\\{$name}";

        // Service Provider
        $fs->put("{$base}/ExtensionServiceProvider.php", <<<PHP
<?php

namespace {$namespace};

use Illuminate\Support\ServiceProvider;

class ExtensionServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        \$this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        \$this->loadRoutesFrom(__DIR__.'/Routes/web.php');
    }
}
PHP);

        // Route
        $fs->put("{$base}/Routes/web.php", <<<PHP
<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])
    ->prefix('extensions')
    ->group(function () {
        //
    });
PHP);

        // Hook example
        $fs->put("{$base}/Hooks/ExampleHook.php", <<<PHP
<?php

namespace {$namespace}\Hooks;

class ExampleHook
{
    public function handle(object \$event): array
    {
        return \$event;
    }
}
PHP);

        // Model
        $fs->put("{$base}/Models/ExampleModel.php", <<<PHP
<?php

namespace {$namespace}\Models;

use Illuminate\Database\Eloquent\Model;

class ExampleModel extends Model
{
    protected \$guarded = [];
}
PHP);

        // extension.json
        $fs->put("{$base}/extension.json", json_encode([
            'name' => Str::kebab($name),
            'version' => '0.1.0',
            'description' => "{$name} extension for LiteERP",
            'status' => false
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // README
        $fs->put("{$base}/README.md", <<<MD
# {$name}

LiteERP extension.

## Description
Describe what this extension does.

## Hooks
- 

## Notes
This extension does not modify core modules.
MD);
    }
}
