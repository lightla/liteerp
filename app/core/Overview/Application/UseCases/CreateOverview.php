<?php

namespace Core\Overview\Application\UseCases;

use Core\Overview\Application\DTOs\CreateOverviewRequest;
use Core\Overview\Domain\Services\OverviewService;

class CreateOverview
{
    public function __construct(private OverviewService $service) {}

    public function handle(CreateOverviewRequest $dto)
    {
        return $this->service->create([
            'name' => $dto->name,
            'description' => $dto->description,
        ]);
    }
}