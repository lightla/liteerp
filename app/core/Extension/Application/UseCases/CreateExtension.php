<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\CreateExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;
use Core\Extension\Infrastructure\Supports\ExtensionInstall;
use Core\Extension\Infrastructure\Supports\ExtensionInstallExecutor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateExtension
{
    public function __construct(private ExtensionService $service, 
        private ExtensionInstall $install, private ExtensionInstallExecutor $exec) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        Event::dispatch('erp.extension.create',$data);
        $dto = CreateExtensionRequest::fromArray($data);
        
        $entity = $this->service->create($dto->toArray());
        $this->exec->execute($this->install->installPlan($entity));   
        DB::commit();
        return $entity;
    }
}