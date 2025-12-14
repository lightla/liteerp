<?php

namespace Core\Notifications\Application\UseCases;

use Core\Notifications\Application\DTOs\UpdateNotificationRequest;
use Core\Notifications\Domain\Services\NotificationDBService;
use Illuminate\Support\Facades\Event;

class UpdateNotification
{
    public function __construct(private NotificationDBService $serviceDB) {}

    public function handle(UpdateNotificationRequest $dto)
    {
        Event::dispatch('erp.notification.update',$dto->toArray());
        return $this->serviceDB->update($dto->toArray());
    }
}