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

class CreateCustomerGroup
{
    public function __construct(private CustomerGroupService $service,
    private CreateActivityLog $createLog) {}

    public function handle(CreateCustomerGroupRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.customergroup.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}