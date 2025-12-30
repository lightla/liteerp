<?php

namespace Core\PriceList\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdatePriceList
{
    public function __construct(private PriceListService $service, private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'PriceList'
            )
        );
        
        $dto = CreatePriceListRequest::fromArray($hooks);
        $update = $this->service->update($dto->toArray());
        
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::UPDATE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$update->toArray(),
                    ...$hooks
                ],
                module: 'PriceList'
            )
        );
        
        Event::dispatch("erp.pricelist.update", [
            ...$hooks,
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        
        DB::commit();
        return $hooks;
    }
}