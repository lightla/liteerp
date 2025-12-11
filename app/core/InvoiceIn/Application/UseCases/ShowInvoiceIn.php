<?php

namespace Core\InvoiceIn\Application\UseCases;

use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Application\DTOs\ShowInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Illuminate\Support\Facades\Event;

class ShowInvoiceIn
{
    public function __construct(private InvoiceInService $service) {}

    public function handle(ShowInvoiceInRequest $dto)
    {
        Event::dispatch('erp.invoicein.show',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->show($dto->toArray());
    }
}