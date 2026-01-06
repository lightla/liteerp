<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\CreateExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;
use Illuminate\Support\Facades\Event;

class CreateExtension
{
    public function __construct(private ExtensionService $service) {}

    public function handle(array $data)
    {
        Event::dispatch('erp.extension.create',$data);
        $dto = CreateExtensionRequest::fromArray($data);
        return $this->service->create($dto->toArray());
    }
}