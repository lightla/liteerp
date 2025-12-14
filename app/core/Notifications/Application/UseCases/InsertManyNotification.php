<?php

namespace Core\Notifications\Application\UseCases;

use App\Jobs\SendMailJob;
use Core\BusinessRole\Application\DTOs\ListUserByBusinessRoleRequest;
use Core\BusinessRole\Application\UseCases\ListUserByBusinessRole;
use Core\Notifications\Application\DTOs\CreateNotificationRequest;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Core\Notifications\Domain\Entities\Notification;
use Core\Notifications\Domain\Services\NotificationDBService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class InsertManyNotification
{
    public function __construct(private NotificationDBService $serviceDB,
    private ListUserByBusinessRole $listUserByBusinessRole) {}

    public function handle(InsertManyNotificationRequest $dto)
    {
        $create = [];
        DB::beginTransaction();
        $users = $this->listUserByBusinessRole->handle(
            ListUserByBusinessRoleRequest::fromArray([
                'role' => $dto->role,
                'business_id' => $dto->business_id,
                'user_id' => $dto->created_by,
            ])
        );
        foreach($users as $k => $user ) {
            foreach($dto->chanels as $key => $chanels) {
                $adapter = new CreateNotificationRequest(
                    user_id: $user['user_id'],
                    message: $dto->message,
                    link: $dto->link ?? URL::to('/dashboard'),
                    title: $dto->title,
                    entity_type: $dto->entity_type,
                    entity_id: $dto->entity_id,
                    chanels: $dto->chanels,
                    type: $dto->type
                );
                switch($chanels) {
                    case "db":
                        $entity = Notification::fromArray($adapter->toArray());
                        $create[$k] = $entity->toArray();
                        break;
                    case "mail":
                        SendMailJob::dispatch($adapter->user_id,$adapter->title,
                            $adapter->message,$adapter->link ?? URL::to('/dashboard'))
                                ->onQueue($adapter->queue ?? 'low');
                        break;
                }
            }
        }
        $data = $this->serviceDB->insertMany($create);
        DB::commit();
        return $data;
    }
}