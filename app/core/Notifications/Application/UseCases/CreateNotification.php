<?php

namespace Core\Notifications\Application\UseCases;

use App\Jobs\SendMailJob;
use Core\Notifications\Application\DTOs\CreateNotificationRequest;
use Core\Notifications\Domain\Entities\Notification;
use Core\Notifications\Domain\Services\NotificationDBService;
use Core\Notifications\Domain\Services\NotificationMailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CreateNotification
{
    public function __construct(private NotificationDBService $serviceDB) {}

    public function handle(CreateNotificationRequest $dto)
    {
        $create = null;
        DB::beginTransaction();
        foreach($dto->chanels as $key => $value ) {
            switch($value) {
                case "db":
                    $create = $this->serviceDB->create($dto->toArray());
                    break;
                case "mail":
                    SendMailJob::dispatch($dto->user_id,$dto->title,
                        $dto->message,$dto->link ?? URL::to('/dashboard'))
                            ->onQueue($dto->queue ?? 'low');
                    break;
            }
        }
        DB::commit();
        return $create;
    }
}