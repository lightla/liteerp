<?php

namespace Core\CustomInvoiceOut\Application\UseCases;

use Core\CustomInvoiceOut\Application\DTOs\DeleteCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;

class DeleteCustomInvoiceOut
{
    public function __construct(private CustomInvoiceOutService $service) {}

    public function handle(DeleteCustomInvoiceOutRequest $dto)
    {
        return $this->service->delete($dto->toArray());
    }
}