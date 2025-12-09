<?php

namespace Core\Purchase\Application\UseCases;
use Core\Purchase\Domain\Services\PurchaseService;
use Core\Purchase\Domain\Entities\Purchase;

class IndexPurchase
{
    public function __construct(private PurchaseService $service) {}

    public function handle(array $dto): array
    {
        return $this->service->index($dto);
    }
}
