<?php

namespace Core\Ordershipping\Application\UseCases;

use Core\Ordershipping\Application\DTOs\CreateOrderShippingRequest;
use Core\Ordershipping\Domain\Services\OrderShippingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(CreateOrderShippingRequest $dto)
    {

        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch('erp.ordershipping.update',[
            ...$update->toArray(),
            'business_id' => $dto->business_id,
            'user_id' => $dto->created_by
        ]);
        DB::commit();
        return $update;
    }
}