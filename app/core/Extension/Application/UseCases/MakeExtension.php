<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\MakeExtensionCommand;
use Core\Extension\Domain\Services\ExtensionService;
use Illuminate\Support\Facades\DB;

class MakeExtension
{
    public function __construct(private ExtensionService $service) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $dto = MakeExtensionCommand::fromArray($data);
        $entity = $this->service->make($dto->toArray());
        DB::commit(); 
        return $entity;
    }
}