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
        \$this->app->tag(
            \Extensions\\{$name}\\Hooks\ViewShowHook::class,
            'liteerp.hooks'
        );
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
        $fs->put("{$base}/Hooks/ViewShowHook.php", <<<PHP
<?php

namespace Extensions\\{$name}\\Hooks;

use App\Supports\Forms\FormFieldRender;
use App\Supports\Forms\FormFieldType;
use App\Supports\Hooks\HookContext;
use App\Contracts\Hooks\HookInterface;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookResult;
use App\Supports\Hooks\HookTiming;

class ViewShowHook implements HookInterface
{
    public static function supports(HookContext \$context): bool
    {
        return \$context->action === HookAction::SHOW
            && \$context->phase === HookPhase::UI
            && \$context->timing === HookTiming::ON;
    }

    public function handle(HookContext \$context): HookResult
    {
        \$form = new FormFieldRender(
            type: FormFieldType::TEXT,
            value: '',
            key: 'fax',
            label: 'Fax'
        );
        return HookResult::pass([
            ...\$context->payload,
            \$form->toArray()
        ]);
    }
}
PHP);

        // Model
        $fs->put("{$base}/Models/{$name}Model.php", <<<PHP
<?php

namespace {$namespace}\Models;

use Illuminate\Database\Eloquent\Model;

class {$name}Model extends Model
{
    protected \$guarded = [];
}
PHP);

        // extension.json
        $fs->put("{$base}/extension.json", json_encode([
            'name' => Str::kebab($name),
            'version' => '0.0.1',
            'description' => "{$name} extension for LiteERP",
            'status' => false,
            "verified"  => true,
            "author" => "Author name",
            "icon" => null,
            "setting_link" => null
            
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
