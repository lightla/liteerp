<?php

namespace Core\Purchase\Application\UseCases;

use Core\Purchase\Application\DTOs\CreatePurchaseRequest;
use Core\Purchase\Domain\Services\PurchaseService;
use Core\Purchase\Domain\Entities\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreatePurchase
{
    public function __construct(private PurchaseService $service) {}

    public function handle(CreatePurchaseRequest $dto): Purchase
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.purchase.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}
