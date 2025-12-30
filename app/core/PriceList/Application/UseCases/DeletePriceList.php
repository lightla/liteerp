<?php

namespace Core\PriceList\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\PriceList\Application\DTOs\DeletePriceListRequest;
use Core\PriceList\Domain\Services\PriceListService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeletePriceList
{
    public function __construct(private PriceListService $service, private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::DELETE,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'PriceList'
            )
        );
        
        $dto = DeletePriceListRequest::fromArray($hooks);
        $delete = $this->service->delete($dto->toArray());
        
        Event::dispatch("erp.pricelist.delete", [
            ...$delete->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        
        DB::commit();
        return $delete;
    }
}