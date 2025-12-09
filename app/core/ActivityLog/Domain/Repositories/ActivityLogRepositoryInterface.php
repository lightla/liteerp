<?php

namespace Core\ActivityLog\Domain\Repositories;

use Core\ActivityLog\Domain\Entities\ActivityLog;

interface ActivityLogRepositoryInterface
{
    public function create(ActivityLog $entity): ActivityLog;
    public function index(array $data) : array;
}