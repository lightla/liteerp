<?php

namespace Core\Order\Application\UseCases;

use Core\Order\Application\DTOs\CreateOrderRequest;
use Core\OrderItem\Application\UseCases\GetSummaryOrderItem;
use Core\Order\Domain\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateOrder
{
    public function __construct(
        private OrderService $service
    ) {}

    public function handle(CreateOrderRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        $notificationStatus = 'update';
        if($update->isApproved()) {
            Event::dispatch("erp.order.approved", [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'id' => $update->id,
                'order_id'     => $update->id,
            ]);  
            $notificationStatus = "approved";
        } else if($update->isCancelled()) {
            Event::dispatch("erp.order.cancelled", [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'id' => $update->id,
                'order_id'     => $update->id,
            ]);
            $notificationStatus = "cancelled";
        } else {
            Event::dispatch("erp.order.update", [
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'id' => $update->id,
                'order_id'     => $update->id,
            ]);
        }
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $notificationStatus,
            'entity_type' => 'order',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $notificationStatus,
            'entity_type' => 'order',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $update;
    }
}
