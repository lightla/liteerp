<?php

namespace Core\InvoiceOut\Application\UseCases;

use Core\InvoiceOut\Application\DTOs\IndexInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Illuminate\Support\Facades\Event;

class IndexInvoiceOut
{
    public function __construct(private InvoiceOutService $service) {}

    public function handle(array $data)
    {
        $dto = IndexInvoiceOutRequest::fromArray($data);
        Event::dispatch('erp.invoiceout.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        $index = $this->service->index($dto->toArray());
        return $index;
    }
}