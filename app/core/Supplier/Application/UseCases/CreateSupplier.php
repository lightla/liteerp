<?php
namespace Core\Supplier\Application\UseCases;

use Core\Supplier\Application\DTOs\CreateSupplierRequest;
use Core\Supplier\Domain\Services\SupplierService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
class CreateSupplier
{
    public function __construct(private SupplierService $service) {}

    public function handle(CreateSupplierRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.supplier.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}