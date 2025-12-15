<?php

namespace Core\ActivityLog\Infrastructure\Listeners;

use App\Exceptions\BadException;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class ActivityLogWrite
{
    public function __construct(private CreateActivityLog $createLog) {}
    public function handle()
    {
        Event::listen('erp.*.*', function (string $eventName, array $data) {
            $name = explode('.', $eventName);
            if (count($name) === 3) {
                $module = $name[0];
                $event = $name[1];
                $action = $name[2];
                if($action === 'index' || $action === 'show') {
                    return;
                }
                if (
                    empty($data['user_id'])
                    || empty($data['business_id'])
                    || empty($data['id'])
                ) {
                    return;
                }
                $this->createLog->handle(CreateActivityLogRequest::fromArray([
                    'user_id' => $data['user_id'],
                    'action' => $action,
                    'description' => $data,
                    'entity_type' => $event,
                    'entity_id' => $data['id'],
                    'business_id' => $data['business_id']
                ]));
            } 
        });
    }
}
