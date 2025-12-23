<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\CreateCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Infrastructure\Events\CustomInvoiceOutEvent;
use Illuminate\Support\Facades\DB;

class UpdateCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(CreateCustomInvoiceOutRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        CustomInvoiceOutEvent::handle('update', [
            ...$dto->toArray(),
            ...$update->toArray()
        ]);
        DB::commit();
        return $update;
    }
}