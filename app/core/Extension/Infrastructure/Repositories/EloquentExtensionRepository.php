<?php

namespace Core\Extension\Infrastructure\Repositories;

use Core\Extension\Domain\Entities\Extension;
use Core\Extension\Domain\Repositories\ExtensionRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class EloquentExtensionRepository implements ExtensionRepositoryInterface
{
    protected string $extensionsPath;

    public function __construct()
    {
        $this->extensionsPath = base_path('extensions');
    }
    public function update(Extension $entity): ?Extension
    {

        $extensionPath = $this->extensionsPath . '/' . $entity->directory;
        $manifestPath  = $extensionPath . '/extension.json';

        /**
         * Toggle enabled flag
         * Default = false
         */
       $entity->isEnabled() ? $entity->disable() : $entity->enable();

        // Save back to file
        File::put(
            $manifestPath,
            json_encode(
                $entity->toArray(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );

        return $entity;
    }
    /**
     * Upload zip & extract extension
     */
    public function create(array $data): ?array
    {
        /** @var UploadedFile $file */
        $file = $data['file'] ?? null;

        if (!$file instanceof UploadedFile) {
            Log::info('Extension file is required');
            return null;
        }

        // Ensure extensions directory exists
        File::ensureDirectoryExists($this->extensionsPath);

        // Store zip temporarily
        $zipPath = $file->storeAs(
            'extensions/tmp',
            uniqid('ext_') . '.zip',
            'local'
        );

        $fullZipPath = storage_path('app/private/' . $zipPath);

        if (!file_exists($fullZipPath)) {
            Log::info('Zip file not found at: ' . $fullZipPath);
            return null;
        }

        $zip = new ZipArchive();

        if ($zip->open($fullZipPath) !== true) {
            Log::info('Cannot open extension zip file');
            return null;
        }

        // Extract to extensions directory
        $zip->extractTo($this->extensionsPath);
        $zip->close();

        // Cleanup zip
        File::delete($fullZipPath);

        return $data;
    }

    /**
     * Scan extensions directory & load extension.json
     */
    public function index(array $data = []): array
    {
        if (!File::exists($this->extensionsPath)) {
            return [];
        }

        $extensions = [];

        foreach (File::directories($this->extensionsPath) as $dir) {
            $manifestPath = $dir . '/extension.json';

            if (!File::exists($manifestPath)) {
                continue;
            }

            $manifest = json_decode(
                File::get($manifestPath),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            // Fallback slug from folder name
            $manifest['directory'] = $dir;
            $item = Extension::fromArray($manifest);
            $extensions[] = $item->toArray();
        }

        return $extensions;
    }

    /**
     * Delete extension folder
     */
    public function delete(Extension $entity): ?Extension
    {
        $directory = $entity->directory;

        $extensionPath = $this->extensionsPath . '/' . $directory;

        // Delete extension directory
        File::deleteDirectory($extensionPath);

        return $entity;
    }
    public function findByDirectory(array $data): ?Extension
    {
        $directory = $data['directory'] ?? null;

        if (!$directory || $directory === '') {
            return null;
        }

        $extensionPath = $this->extensionsPath . '/' . $directory;
        $manifestPath  = $extensionPath . '/extension.json';

        if (!File::exists($manifestPath)) {
            return null;
        }

        $manifest = json_decode(
            File::get($manifestPath),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $entity = Extension::fromArray($manifest);
        $entity->directory = $directory;
        return $entity;
    }
}
