<?php

namespace Core\PriceList\Application\UseCases;

use Core\PriceList\Application\DTOs\DeletePriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeletePriceList
{
    public function __construct(private PriceListService $service) {}

    public function handle(DeletePriceListRequest $dto)
    {
        DB::beginTransaction();
        $delete = $this->service->delete($dto->toArray());
        Event::dispatch("erp.pricelist.delete", [
            ...$delete->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $delete;
    }
}