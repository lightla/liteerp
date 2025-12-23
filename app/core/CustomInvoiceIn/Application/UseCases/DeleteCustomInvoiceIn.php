<?php

namespace Core\CustomInvoiceIn\Application\UseCases;

use Core\CustomInvoiceIn\Application\DTOs\DeleteCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Domain\Services\CustomInvoiceInService;

class DeleteCustomInvoiceIn
{
    public function __construct(private CustomInvoiceInService $service) {}

    public function handle(DeleteCustomInvoiceInRequest $dto)
    {
        return $this->service->delete($dto->toArray());
    }
}