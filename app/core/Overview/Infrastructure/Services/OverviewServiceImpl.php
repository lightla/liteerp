<?php

namespace Core\Overview\Infrastructure\Services;

use Core\Overview\Domain\Services\OverviewService;
use Core\Overview\Domain\Repositories\OverviewRepositoryInterface;
use Core\Overview\Domain\Entities\Overview;

class OverviewServiceImpl implements OverviewService
{
    public function __construct(private OverviewRepositoryInterface $repo) {}

    public function create(array $data): Overview
    {
        $entity = new Overview(
            name: $data['name'],
            description: $data['description'] ?? null
        );

        return $this->repo->create($entity);
    }
}