<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\DeleteExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;
use Core\Extension\Infrastructure\Supports\ExtensionInstall;
use Core\Extension\Infrastructure\Supports\ExtensionInstallExecutor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteExtension
{
    public function __construct(private ExtensionService $service,
        private ExtensionInstall $install, private ExtensionInstallExecutor $exec) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        Event::dispatch('erp.extension.delete',$data);
        $dto = DeleteExtensionRequest::fromArray($data);
        $entity = $this->service->findById($dto->toArray());
        $this->exec->execute($this->install->installPlan($entity));   
        $entity = $this->service->delete($entity->toArray());
        DB::commit();
        return $entity;
    }
}