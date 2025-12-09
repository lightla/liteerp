<?php

namespace Core\PriceList\Application\UseCases;

use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;

class IndexPriceList
{
    public function __construct(private PriceListService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index($dto);
    }
}