<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\IndexCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Infrastructure\Events\CustomInvoiceOutEvent;

class IndexCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(IndexCustomInvoiceOutRequest $dto)
    {
        CustomInvoiceOutEvent::handle('index', [
            ...$dto->toArray()
        ]);
        return $this->service->index($dto->toArray());
    }
}