<?php

namespace Core\InvoiceOut\Application\UseCases;

use Core\InvoiceOut\Application\DTOs\ShowInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;

class ShowInvoiceOut
{
    public function __construct(private InvoiceOutService $service) {}

    public function handle(ShowInvoiceOutRequest $dto)
    {
        return $this->service->show($dto->toArray());
    }
}