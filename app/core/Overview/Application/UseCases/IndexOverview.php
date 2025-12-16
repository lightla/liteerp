<?php

namespace Core\Overview\Application\UseCases;

use Core\Overview\Application\DTOs\IndexOverviewRequest;
use Core\Overview\Domain\Services\OverviewService;

class IndexOverview
{
    public function __construct(private OverviewService $service) {}

    public function handle(IndexOverviewRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}