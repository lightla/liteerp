<?php

namespace Core\OrderItem\Application\UseCases;

use Core\OrderItem\Domain\Services\OrderItemService;
use Core\Order\Application\UseCases\FindOneById;
use Core\OrderItem\Application\DTOs\GetSummaryOrderItemRequest;
use Illuminate\Support\Facades\Event;

class GetSummaryOrderItem
{
    public function __construct(private OrderItemService $service) {}

    public function handle(GetSummaryOrderItemRequest $dto)
    {
        $summary = $this->service->summary($dto->toArray());

        Event::dispatch('erp.orderitem.summary', [
            'business_id' => $dto->business_id,
            'user_id'   => $dto->created_by,
            'order_id' => $dto->order_id,
            'subtotal'     => $summary['subtotal'],
            'tax'          => $summary['tax'],
            'discount'     => $summary['discount'],
            'total'        => $summary['total'],
            'id' => $dto->order_id,
        ]);
    }
}
