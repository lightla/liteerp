<?php

namespace Core\Product\Application\UseCases;

use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Application\DTOs\DeleteProductRequest;
use Core\Product\Domain\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteProduct
{
    public function __construct(private ProductService $service) {}

    public function handle(DeleteProductRequest $dto)
    {
        DB::beginTransaction();
        $delete = $this->service->delete($dto->toArray());
        Event::dispatch("erp.product.delete", [
            ...$delete->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $delete;
    }
}
