<?php

namespace Core\Extension\Application\UseCases;

use Core\Extension\Application\DTOs\UpdateExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;
use Illuminate\Support\Facades\Event;

class UpdateExtension
{
    public function __construct(private ExtensionService $service) {}

    public function handle(array $data)
    {
        Event::dispatch('erp.extension.update',$data);
        $dto = UpdateExtensionRequest::fromArray($data);
        return $this->service->update($dto->toArray());
    }
}