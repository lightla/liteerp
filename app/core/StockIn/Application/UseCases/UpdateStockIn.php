<?php

namespace Core\StockIn\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\StockIn\Application\DTOs\CreateStockInRequest;
use Core\StockIn\Domain\Services\StockInService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateStockIn
{
    public function __construct(private StockInService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'StockIn'
            )
        );
        $dto = CreateStockInRequest::fromArray($data);
        $update = $this->service->update($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: [
                    ...$data,
                    ...$update->toArray()
                ],
                module: 'StockIn'
            )
        );
        if ($update->isReceived()) {
            Event::dispatch("erp.stockin.received", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id
            ]);
        } else {
            Event::dispatch("erp.stockin.update", [
                ...$update->toArray(),
                'user_id' => $dto->created_by,
                'business_id' => $dto->business_id
            ]);
        }
        Event::dispatch("erp.notification.many", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $update->isReceived() ? 'received' : 'updated',
            'entity_type' => 'stockin',
            'entity_id' => $update->id,
            'chanels' => ['db'],
            'roles' => ['admin','manager']
        ]);
        Event::dispatch("erp.notification.create", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            'type' => $update->isReceived() ? 'received' : 'updated',
            'entity_type' => 'stockin',
            'entity_id' => $update->id,
            'chanels' => ['db']
        ]);
        DB::commit();
        return $update;
    }
}
