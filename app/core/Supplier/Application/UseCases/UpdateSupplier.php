<?php

namespace Core\Supplier\Application\UseCases;

use Core\Supplier\Application\DTOs\CreateSupplierRequest;
use Core\Supplier\Domain\Services\SupplierService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateSupplier
{
    public function __construct(private SupplierService $service) {}

    public function handle(CreateSupplierRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.supplier.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}