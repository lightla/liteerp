<?php

namespace Core\Overview\Domain\Repositories;

use Core\Overview\Domain\Entities\Overview;

interface OverviewRepositoryInterface
{
    public function create(Overview $entity): Overview;
}