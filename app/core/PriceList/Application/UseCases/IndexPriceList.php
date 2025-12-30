<?php

namespace Core\PriceList\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\PriceList\Application\DTOs\IndexPriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\Event;

class IndexPriceList
{
    public function __construct(private PriceListService $service, private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'PriceList'
            )
        );
        $dto = IndexPriceListRequest::fromArray($hooks);
        Event::dispatch("erp.pricelist.index", [
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id,
            ...$dto->toArray()
        ]);
        
        return $this->service->index($dto->toArray());
    }
}