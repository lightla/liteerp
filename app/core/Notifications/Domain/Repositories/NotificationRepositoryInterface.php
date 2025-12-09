<?php

namespace Core\Notifications\Domain\Repositories;

use Core\Notifications\Domain\Entities\Notification;

interface NotificationRepositoryInterface
{
    public function create(Notification $entity): Notification;
    public function insertMany(array $data) : array;
}