<?php

namespace Core\Notifications\Infrastructure\Repositories;

use App\Models\NotificationModel;
use Core\Notifications\Domain\Repositories\NotificationRepositoryInterface;
use Core\Notifications\Domain\Entities\Notification;

class EloquentNotificationRepository implements NotificationRepositoryInterface
{
    public function create(Notification $entity): Notification
    {
        $create = NotificationModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function insertMany(array $data): array
    {
        NotificationModel::insert($data);
        return $data;
    }
}