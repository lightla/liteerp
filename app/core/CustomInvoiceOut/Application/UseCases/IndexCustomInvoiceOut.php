<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\IndexCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;

class IndexCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(IndexCustomInvoiceOutRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}