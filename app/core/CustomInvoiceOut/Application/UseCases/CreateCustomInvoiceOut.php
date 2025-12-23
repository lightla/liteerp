<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\CreateCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Infrastructure\Events\CustomInvoiceOutEvent;
use Illuminate\Support\Facades\DB;

class CreateCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(CreateCustomInvoiceOutRequest $dto)
    {
        DB::beginTransaction();
        
        $create = $this->service->create($dto->toArray());

        CustomInvoiceOutEvent::handle('create', [
            ...$dto->toArray(),
            ...$create->toArray()
        ]);
        DB::commit();

        return $create;
    }
}
