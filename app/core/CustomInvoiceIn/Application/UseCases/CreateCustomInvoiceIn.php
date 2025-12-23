<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\CreateCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;

class CreateCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(CreateCustomInvoiceInRequest $dto)
    {
        return $this->service->create($dto->toArray());
    }
}