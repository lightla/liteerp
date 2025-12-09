<?php

namespace Core\InvoiceIn\Application\UseCases;

use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\InvoiceIn\Application\DTOs\CreateInvoiceInRequest;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class CreateInvoiceIn
{
    public function __construct(private InvoiceInService $service) {}

    public function handle(CreateInvoiceInRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.invoicein.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}