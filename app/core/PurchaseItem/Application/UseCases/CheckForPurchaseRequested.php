<?php

namespace Core\PurchaseItem\Application\UseCases;

use App\Exceptions\BadException;
use Core\PurchaseItem\Application\DTOs\CheckForPurchaseRequestedRequest;
use Core\PurchaseItem\Domain\Entities\PurchaseItem;
use Core\PurchaseItem\Domain\Services\PurchaseItemService;

class CheckForPurchaseRequested
{
    public function __construct(private PurchaseItemService $service) {}

    public function handle(CheckForPurchaseRequestedRequest $dto)
    {
        $index = $this->service->indexMinimal($dto->toArray());
        if (count($index) == false) {
            throw new BadException(__("You are not yet add products"));
        }
    }
}
