<?php

namespace Core\InvoiceOut\Application\UseCases;

use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\InvoiceOut\Application\DTOs\CreateInvoiceOutRequest;
use Core\InvoiceOut\Domain\Services\InvoiceOutService;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class CreateInvoiceOut
{
    public function __construct(private InvoiceOutService $service) {}

    public function handle(CreateInvoiceOutRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.invoiceout.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}