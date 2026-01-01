<?php

namespace Core\OrderShipping\Application\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Models\ShippingModel;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;

class IndexQuery implements QueryInterface
{
    function __construct(private HookDispatcher $hooks)
    {
        
    }
    function handle(array $data): array
    {
        $list = ShippingModel::select(
            "shippings.*",
            "shipping_providers.name as shipping_provider_name"
        )
            ->join("orders", "orders.id", "=", "shippings.order_id")
            ->join(
                "shipping_providers",
                "shipping_providers.id",
                "=",
                "shippings.preferred_unit"
            )
            ->where('orders.business_id', $data['business_id']);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::QUERY,
                timing: HookTiming::ON,
                payload: [
                    'data' => $data,
                    'query' => $list
                ],
                module: 'OrderShipping'
            )
        );
        $list = $data['query'];
        $data = $data['data'];
        return $list->paginate(15)
            ->toArray();
    }
}
