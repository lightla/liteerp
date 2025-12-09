<?php

namespace Core\PriceList\Application\UseCases;

use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class CreatePriceList
{
    public function __construct(private PriceListService $service,
    private CreateActivityLog $createLog) {}

    public function handle(CreatePriceListRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.product.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}