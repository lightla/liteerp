<?php

namespace Core\PriceList\Application\UseCases;

use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Application\DTOs\IndexPriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;

class IndexPriceList
{
    public function __construct(private PriceListService $service) {}

    public function handle(IndexPriceListRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}