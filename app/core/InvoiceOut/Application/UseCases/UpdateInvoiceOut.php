<?php

namespace Core\InvoiceOut\Application\UseCases;

use Core\Inventory\Application\UseCases\FindInventoryById;
use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Core\OrderItem\Application\UseCases\IndexOrderItem;
use Core\StockMovementOut\Application\DTOs\CreateStockMovementOutRequest;
use Core\StockMovementOut\Application\UseCases\CreateStockMovementOut;
use Core\StockOut\Application\DTOs\CreateStockOutRequest;
use Core\StockOut\Application\UseCases\CreateStockOut;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateInvoiceOut
{
    public function __construct(
        private InvoiceOutService $service
    ) {}

    public function handle(CreateInvoiceOutRequest $dto)
    {
        DB::beginTransaction();
        $arrayData = $dto->toArray();
        $findInvoice = $this->service->findById($arrayData);
        $update = $this->service->update($arrayData);
        if($arrayData['approved'] === true && !$findInvoice->isApproved()) {
            Event::dispatch("erp.invoiceout.approved", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_out_id' => $update->id
            ]);  
        } else {
            Event::dispatch("erp.invoiceout.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id,
                'invoice_out_id' => $update->id
            ]);    
        }
        
        DB::commit();
        return $update;
    }
}
