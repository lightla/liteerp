<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Application\DTOs\IndexInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Illuminate\Support\Facades\Event;

class IndexInvoiceIn
{
    public function __construct(private InvoiceInService $service) {}

    public function handle(array $data)
    {
        $dto = IndexInvoiceInRequest::fromArray($data);
        Event::dispatch('erp.invoicein.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->index($dto->toArray());
    }
}