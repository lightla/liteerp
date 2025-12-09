<?php

namespace Core\Product\Application\UseCases;

use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Domain\Services\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateProduct
{
    public function __construct(private ProductService $service) {}

    public function handle(CreateProductRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.product.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}
