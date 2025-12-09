<?php

namespace Core\Order\Application\UseCases;

use Core\Order\Application\DTOs\CreateOrderRequest;
use Core\Order\Domain\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateOrder
{
    public function __construct(private OrderService $service, ) {}

    public function handle(CreateOrderRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.order.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}