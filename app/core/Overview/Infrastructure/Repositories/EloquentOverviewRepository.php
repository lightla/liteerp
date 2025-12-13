<?php

namespace Core\Overview\Infrastructure\Repositories;

use Core\Overview\Domain\Repositories\OverviewRepositoryInterface;
use Core\Overview\Domain\Entities\Overview;

class EloquentOverviewRepository implements OverviewRepositoryInterface
{
    public function create(Overview $entity): Overview
    {
        // TODO: Add actual database logic
        return $entity;
    }
}