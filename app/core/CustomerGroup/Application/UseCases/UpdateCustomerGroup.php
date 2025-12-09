<?php

namespace Core\CustomerGroup\Application\UseCases;

use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\CustomerGroup\Application\DTOs\CreateCustomerGroupRequest;
use Core\CustomerGroup\Domain\Services\CustomerGroupService;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class UpdateCustomerGroup
{
    public function __construct(private CustomerGroupService $service) {}

    public function handle(CreateCustomerGroupRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.customergroup.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}