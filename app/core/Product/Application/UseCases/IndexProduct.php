<?php

namespace Core\Product\Application\UseCases;

use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Application\DTOs\IndexProductRequest;
use Core\Product\Domain\Services\ProductService;
use Illuminate\Support\Facades\Event;

class IndexProduct
{
    public function __construct(private ProductService $service) {}

    public function handle(IndexProductRequest $dto)
    {
        Event::dispatch("erp.product.index", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->index($dto->toArray());
    }
}