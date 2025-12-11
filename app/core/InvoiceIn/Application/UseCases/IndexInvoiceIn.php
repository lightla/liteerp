<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Application\DTOs\IndexInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;

class IndexInvoiceIn
{
    public function __construct(private InvoiceInService $service) {}

    public function handle(IndexInvoiceInRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}