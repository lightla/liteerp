<?php

namespace Core\CategoryProduct\Application\UseCases;

use Core\CategoryProduct\Application\DTOs\CreateCategoryProductRequest;
use Core\CategoryProduct\Domain\Services\CategoryProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateCategoryProduct
{
    public function __construct(private CategoryProductService $service) {}

    public function handle(CreateCategoryProductRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.categoryproduct.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}