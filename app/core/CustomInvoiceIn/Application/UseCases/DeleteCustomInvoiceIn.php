<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\DeleteCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;
use Core\CustomInvoiceIn\Infrastructure\Events\CustomInvoiceInEvent;
use Illuminate\Support\Facades\DB;

class DeleteCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(DeleteCustomInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        $delete = $this->service->delete($dto->toArray());
        CustomInvoiceInEvent::handle('delete',[
            ...$dto->toArray(),
            ...$delete->toArray()
        ]);
        DB::commit();
        return $delete;
    }
}