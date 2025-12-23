<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\CreateCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;
use Core\CustomInvoiceIn\Infrastructure\Events\CustomInvoiceInEvent;
use Illuminate\Support\Facades\DB;

class CreateCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(CreateCustomInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        CustomInvoiceInEvent::handle('create',[
            ...$dto->toArray(),
            ...$create->toArray()
        ]);
        DB::commit();
        return $create;
    }
}