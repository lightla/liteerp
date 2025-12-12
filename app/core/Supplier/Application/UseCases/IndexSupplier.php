<?php

namespace Core\Supplier\Application\UseCases;

use Core\Supplier\Application\DTOs\IndexSupplierRequest as DTOsIndexSupplierRequest;
use Core\Supplier\Domain\Services\SupplierService;
use Illuminate\Support\Facades\Event;

class IndexSupplier
{
    public function __construct(private SupplierService $service) {}

    public function handle(DTOsIndexSupplierRequest $dto)
    {
        Event::dispatch("erp.supplier.index", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->index($dto->toArray());
    }
}