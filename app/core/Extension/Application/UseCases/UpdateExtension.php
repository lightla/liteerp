<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\UpdateExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;
use Core\Extension\Domain\Supports\ExtensionChange;

class UpdateExtension
{
    public function __construct(private ExtensionService $service) {}

    public function handle(array $data)
    {
        $dto = UpdateExtensionRequest::fromArray($data);
        $update = $this->service->update($dto->toArray());
        return $update;
    }
}