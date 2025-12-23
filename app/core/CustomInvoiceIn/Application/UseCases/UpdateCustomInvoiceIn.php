<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\CreateCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;

class UpdateCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(CreateCustomInvoiceInRequest $dto)
    {
        return $this->service->update($dto->toArray());
    }
}