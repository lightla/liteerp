<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\IndexCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;
use Core\CustomInvoiceIn\Infrastructure\Events\CustomInvoiceInEvent;
use Illuminate\Support\Facades\DB;

class IndexCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(IndexCustomInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        $index = $this->service->index($dto->toArray());
        CustomInvoiceInEvent::handle('index',[
            ...$dto->toArray()
        ]);
        DB::commit();
        return $index;
    }
}