<?php

namespace Core\StockOut\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\StockOut\Application\DTOs\IndexStockOutRequest;
use Core\StockOut\Domain\Services\StockOutService;
use Illuminate\Support\Facades\Event;

class IndexStockOut
{
    public function __construct(private StockOutService $service,
        private HookDispatcher $hooks) {}

    public function handle(array $data) : array
    {
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'StockOut'
            )
        );
        $dto = IndexStockOutRequest::fromArray($data);
        Event::dispatch('erp.stockout.index',[
            ...$dto->toArray(),
            'user_id' => $dto->created_by
        ]);
        return $this->service->index($dto->toArray());
    }
}