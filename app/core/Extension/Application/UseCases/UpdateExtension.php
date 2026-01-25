<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\UpdateExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;

class UpdateExtension
{
    public function __construct(private ExtensionService $service) {}

    public function handle(array $data)
    {
        $dto = UpdateExtensionRequest::fromArray($data);
        return $this->service->update($dto->toArray());
    }
}