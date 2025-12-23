<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\DeleteCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Infrastructure\Events\CustomInvoiceOutEvent;
use Illuminate\Support\Facades\DB;

class DeleteCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(DeleteCustomInvoiceOutRequest $dto)
    {
        DB::beginTransaction();
        $delete = $this->service->delete($dto->toArray());
        CustomInvoiceOutEvent::handle('delete', [
            ...$dto->toArray(),
            ...$delete->toArray()
        ]);
        DB::commit();
        return $delete;
    }
}