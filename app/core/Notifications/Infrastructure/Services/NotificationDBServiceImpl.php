<?php

namespace Core\Notifications\Infrastructure\Services;

use Core\Notifications\Domain\Services\NotificationDBService;
use Core\Notifications\Domain\Repositories\NotificationRepositoryInterface;
use Core\Notifications\Domain\Entities\Notification;

class NotificationDBServiceImpl implements NotificationDBService
{
    public function __construct(private NotificationRepositoryInterface $repo) {}

    public function create(array $data): Notification
    {
        $entity = Notification::fromArray($data);
        return $this->repo->create($entity);
    }
    public function insertMany(array $data): array
    {
        return $this->repo->insertMany($data);
    }
}