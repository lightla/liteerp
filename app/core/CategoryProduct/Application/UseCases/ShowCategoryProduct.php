<?php

namespace Core\CategoryProduct\Application\UseCases;

use Core\CategoryProduct\Domain\Services\CategoryProductService;
use Core\CategoryProduct\Http\Requests\ShowCategoryProductRequest;

class ShowCategoryProduct
{
    public function __construct(private CategoryProductService $service) {}

    public function handle(array $dto)
    {
        return $this->service->show($dto['id']);
    }
}