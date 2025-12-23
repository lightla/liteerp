<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\IndexCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;

class IndexCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(IndexCustomInvoiceInRequest $dto)
    {
        return $this->service->index($dto->toArray());
    }
}