<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;

class ShowInvoiceIn
{
    public function __construct(private InvoiceInService $service) {}

    public function handle(array $dto)
    {
        return $this->service->show($dto);
    }
}