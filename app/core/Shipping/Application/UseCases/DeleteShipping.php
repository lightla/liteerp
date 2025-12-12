<?php

namespace Core\Shipping\Application\UseCases;

use Core\Shipping\Application\DTOs\DeleteShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;
use Illuminate\Support\Facades\Event;

class DeleteShipping
{
    public function __construct(private ShippingService $service) {}

    public function handle(DeleteShippingRequest $dto)
    {
        Event::dispatch("erp.shipping.delete", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->delete($dto->toArray());
    }
}