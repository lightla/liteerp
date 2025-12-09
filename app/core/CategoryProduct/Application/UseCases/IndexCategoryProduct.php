<?php

namespace Core\CategoryProduct\Application\UseCases;

use Core\CategoryProduct\Domain\Services\CategoryProductService;
use Core\CategoryProduct\Http\Requests\IndexCategoryProductRequest;

class IndexCategoryProduct
{
    public function __construct(private CategoryProductService $service) {}

    public function handle(array $dto)
    {
        return $this->service->index([
            'business_id' => $dto['business_id'],
            'keywords' => $dto['keywords'] ?? ''
        ]);
    }
}