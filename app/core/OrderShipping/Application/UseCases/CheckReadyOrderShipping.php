<?php

namespace Core\Ordershipping\Application\UseCases;

use App\Exceptions\BadException;
use Core\Ordershipping\Application\DTOs\CheckReadyOrderShippingRequest;
use Core\Ordershipping\Domain\Services\OrderShippingService;

class CheckReadyOrderShipping
{
    public function __construct(private OrderShippingService $service) {}

    public function handle(CheckReadyOrderShippingRequest $dto)
    {
        $ordershipping = $this->service->findByOrderId($dto->toArray());
        if(!$ordershipping->isReady()) {
            throw new BadException(__("You are not yet selecting to service shipping"));
        }
    }
}