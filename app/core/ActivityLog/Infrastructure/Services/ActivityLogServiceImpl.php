<?php

namespace Core\ActivityLog\Infrastructure\Services;

use Core\ActivityLog\Domain\Services\ActivityLogService;
use Core\ActivityLog\Domain\Repositories\ActivityLogRepositoryInterface;
use Core\ActivityLog\Domain\Entities\ActivityLog;

class ActivityLogServiceImpl implements ActivityLogService
{
    public function __construct(private ActivityLogRepositoryInterface $repo) {}

    public function create(array $data): ActivityLog
    {
        $entity = ActivityLog::fromArray($data);

        return $this->repo->create($entity);
    }
    public function index(array $data) : array {
        return $this->repo->index($data);
    }
}