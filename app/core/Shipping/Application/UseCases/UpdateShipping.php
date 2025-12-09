<?php

namespace Core\Shipping\Application\UseCases;

use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Core\Shipping\Application\DTOs\CreateShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class UpdateShipping
{
    public function __construct(private ShippingService $service,
    private CreateActivityLog $createLog) {}

    public function handle(CreateShippingRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.shipping.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}