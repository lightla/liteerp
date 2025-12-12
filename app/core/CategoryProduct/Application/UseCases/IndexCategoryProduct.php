<?php

namespace Core\CategoryProduct\Application\UseCases;

use Core\CategoryProduct\Application\DTOs\IndexCategoryProductRequest as DTOsIndexCategoryProductRequest;
use Core\CategoryProduct\Domain\Services\CategoryProductService;
use Core\CategoryProduct\Http\Requests\IndexCategoryProductRequest;
use Illuminate\Support\Facades\Event;

class IndexCategoryProduct
{
    public function __construct(private CategoryProductService $service) {}

    public function handle(DTOsIndexCategoryProductRequest $dto)
    {
        Event::dispatch("erp.categoryproduct.index", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->index($dto->toArray());
    }
}