<?php

namespace Core\Notifications\Domain\Services;

use Core\Notifications\Domain\Entities\Notification;

interface NotificationDBService
{
    public function create(array $data): Notification;
    public function insertMany(array $data) : array;
}