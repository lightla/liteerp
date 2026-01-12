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
                $notiAdapter = InsertManyNotificationRequest::fromArray($data);

                CreateNotificationJob::dispatch($notiAdapter->toArray())->onQueue($notiAdapter->getQueue());
            } else if ($eventName === 'erp.notification.create') {
                
                $notiAdapter = CreateNotificationRequest::fromArray($data);
                $CreateNotification->handle($notiAdapter);
            }
        });
    }
}
