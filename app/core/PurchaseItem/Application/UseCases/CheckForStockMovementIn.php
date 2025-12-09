<?php

namespace Core\PurchaseItem\Application\UseCases;

use App\Exceptions\BadException;
use Core\PurchaseItem\Application\DTOs\CheckForStockMovementInRequest;
use Core\PurchaseItem\Domain\Entities\PurchaseItem;
use Core\PurchaseItem\Domain\Services\PurchaseItemService;

class CheckForStockMovementIn
{
    public function __construct(private PurchaseItemService $service) {}

    public function handle(CheckForStockMovementInRequest $dto): PurchaseItem
    {

        $row = $this->service->findById($dto->toArray());
        if ($row->totalQuantity() < $dto->qty_change) {
            throw new BadException(__("Quantity order product can not less than stock movement in"));
        }
        return $row;
    }
}
