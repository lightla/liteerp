<?php

namespace Core\Supplier\Application\UseCases;

use Core\Supplier\Application\DTOs\DeleteSupplierRequest;
use Core\Supplier\Domain\Services\SupplierService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteSupplier
{
    public function __construct(private SupplierService $service) {}

    public function handle(DeleteSupplierRequest $dto)
    {
        DB::beginTransaction();
        $delete = $this->service->delete($dto->toArray());
        Event::dispatch("erp.supplier.delete", [
            ...$delete->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $delete;
    }
}