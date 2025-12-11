<?php

namespace Core\PriceList\Application\UseCases;

use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Application\DTOs\IndexPriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\Event;

class IndexPriceList
{
    public function __construct(private PriceListService $service) {}

    public function handle(IndexPriceListRequest $dto)
    {
        Event::dispatch("erp.pricelist.delete", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            ...$dto->toArray()
        ]);
        return $this->service->index($dto->toArray());
    }
}