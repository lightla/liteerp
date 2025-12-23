<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\CreateCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;

class CreateCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(CreateCustomInvoiceOutRequest $dto)
    {
        return $this->service->create($dto->toArray());
    }
}