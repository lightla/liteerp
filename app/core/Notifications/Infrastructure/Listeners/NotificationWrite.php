<?php

namespace Core\Notifications\Infrastructure\Listeners;

use App\Exceptions\BadException;
use App\Jobs\CreateNotificationJob;
use Core\Notifications\Application\DTOs\CreateNotificationRequest;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Core\Notifications\Application\UseCases\CreateNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class NotificationWrite
{
    public function handle(CreateNotification $CreateNotification)
    {

        Event::listen("erp.notification.*", function (string $eventName, array $data) use($CreateNotification) {
            if ($eventName === 'erp.notification.many') {
                $notiAdapter = new InsertManyNotificationRequest(
                    message: $data['message'] ?? null,
                    title: $data['title'] ?? null,
                    entity_type: $data['title'] ?? null,
                    entity_id: $data['entity_id'],
                    chanels: $data['chanels'] ?? ['db'],
                    business_id: $data['business_id'],
                    link: $data['link'] ?? URL::to('/dashboard'),
                    role: $data['role'] ?? ['admin', 'manager'],
                    created_by: $data['user_id'],
                    queue: $data['queue'] ?? null,
                    type: $data['type']  
                );

                CreateNotificationJob::dispatch($notiAdapter->toArray())->onQueue('low');
            } else if ($eventName === 'erp.notification.create') {
                
                $notiAdapter = new CreateNotificationRequest(
                    user_id: $data['user_id'],
                    message: $data['message'] ?? null,
                    link: $data['link'] ?? null,
                    title: $data['title'] ?? null,
                    entity_type: $data['entity_type'],
                    entity_id: $data['entity_id'] ?? null,
                    queue: $data['queue'] ?? null,
                    type: $data['type'],
                    chanels: $data['chanels'],
                    business_id: $data['business_id'],
                );
                Log::info(json_encode($notiAdapter));
                $CreateNotification->handle($notiAdapter);
            }
        });
    }
}
