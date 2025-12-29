<?php

namespace Core\Shipping\Application\UseCases;

use Core\Shipping\Application\DTOs\CreateShippingRequest;
use Core\Shipping\Application\DTOs\ShowShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;
use Illuminate\Support\Facades\Event;

class ShowShipping
{
    public function __construct(private ShippingService $service) {}

    public function handle(array $data)
    {
        $dto = ShowShippingRequest::fromArray($data);
        Event::dispatch("erp.shipping.create", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->show($dto->toArray());
    }
}