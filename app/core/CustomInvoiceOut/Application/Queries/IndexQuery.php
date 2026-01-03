<?php 
namespace Core\CustomInvoiceOut\Application\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Models\CustomInvoiceOutModel;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;

class IndexQuery implements QueryInterface {
    public function __construct(private HookDispatcher $hooks) {}
    function handle(array $data): array
    {
        $list = CustomInvoiceOutModel::select("custom_invoice_outs.*",
            "customers.name as customer_name")
        ->join("customers","customers.id","=","custom_invoice_outs.customer_id")
        ->where('custom_invoice_outs.business_id',$data['business_id']);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::QUERY,
                timing: HookTiming::ON,
                payload: [
                    'data' => $data,
                    'query' => $list
                ],
                module: 'CustomInvoiceOut'
            )
        );
        $list = $data['query'];
        $data = $data['data'];
        return $list->paginate(15)->toArray();
    }
}