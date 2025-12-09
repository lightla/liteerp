<?php

namespace Core\PurchaseItem\Application\UseCases;
use Core\PurchaseItem\Domain\Services\PurchaseItemService;

class IndexPurchaseItem
{
    public function __construct(private PurchaseItemService $service) {}

    public function handle(array $dto)
    {
        
        return $this->service->index($dto);
    }
}