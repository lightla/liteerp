<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\CreateCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;
use Core\CustomInvoiceIn\Infrastructure\Events\CustomInvoiceInEvent;
use Illuminate\Support\Facades\DB;

class UpdateCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(CreateCustomInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->update($dto->toArray());
        CustomInvoiceInEvent::handle('update',[
            ...$dto->toArray(),
            ...$update->toArray()
        ]);
        DB::commit();
        return $update;
    }
}