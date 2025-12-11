<?php

namespace Core\InvoiceOut\Application\UseCases;

use Core\InvoiceOut\Application\DTOs\ShowInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Illuminate\Support\Facades\Event;

class ShowInvoiceOut
{
    public function __construct(private InvoiceOutService $service) {}

    public function handle(ShowInvoiceOutRequest $dto)
    {
        Event::dispatch('erp.invoiceout.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->show($dto->toArray());
    }
}