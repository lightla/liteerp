<?php

namespace Core\Order\Application\UseCases;

use App\Exceptions\BadException;
use Core\Order\Application\DTOs\CheckAddOrderItemRequest;
use Core\Order\Domain\Services\OrderService;

class CheckAddOrderItem
{
    public function __construct(private OrderService $service) {}

    public function handle(CheckAddOrderItemRequest $dto)
    {
        $row = $this->service->findOneById($dto->toArray());
        if(!$row->isPending()) {
            throw new BadException(__("Currently this order status can not add product"));
        }
        return $row;
    }
}