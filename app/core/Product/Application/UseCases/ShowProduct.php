<?php

namespace Core\Product\Application\UseCases;

use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Domain\Services\ProductService;

class ShowProduct
{
    public function __construct(private ProductService $service) {}

    public function handle(array $dto)
    {
        return $this->service->show($dto);
    }
}