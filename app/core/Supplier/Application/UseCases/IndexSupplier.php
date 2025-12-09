<?php

namespace Core\Supplier\Application\UseCases;

use Core\Supplier\Application\DTOs\CreateSupplierRequest;
use Core\Supplier\Application\DTOs\IndexSupplierRequest as DTOsIndexSupplierRequest;
use Core\Supplier\Domain\Services\SupplierService;
use Core\Supplier\Http\Requests\IndexSupplierRequest;

class IndexSupplier
{
    public function __construct(private SupplierService $service) {}

    public function handle(DTOsIndexSupplierRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}