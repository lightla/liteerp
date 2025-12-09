<?php

namespace Core\PriceList\Application\UseCases;

use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdatePriceList
{
    public function __construct(private PriceListService $service) {}

    public function handle(CreatePriceListRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.product.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}