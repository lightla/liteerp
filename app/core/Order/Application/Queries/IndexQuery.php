<?php 
namespace Core\Order\Application\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Models\OrderModel;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Order\Application\DTOs\IndexOrderRequest;
use Illuminate\Support\Facades\DB;

class IndexQuery implements QueryInterface {
    function __construct(
        private HookDispatcher $hooks)
    {
        
    }
    function handle(array $data): array
    {
        $dto = IndexOrderRequest::fromArray($data);
        $list = OrderModel::select(
            "orders.*",
            "customers.name as customer_name",
            "customers.address as customer_address",
            "created_user.name as created_name",
            "approved_user.name as approved_name",
            DB::raw("SUM(order_items.buy_quantity) as total_buy"),
            DB::raw("SUM(order_items.gift_quantity) as total_gift"),
            DB::raw("SUM(order_items.compensation_quantity) as total_comp"),
            DB::raw("SUM(order_items.conversion_quantity) as total_convert"),
            DB::raw("SUM(order_items.discount) as total_discount"),
            DB::raw("COUNT(order_items.id) as total_product")
        )->join("customers", "customers.id", "=", "orders.customer_id")
            ->join("users as created_user", "created_user.id", "=", "orders.created_by")
            ->leftJoin("users as approved_user", "approved_user.id", "=", "orders.approved_by")
            ->leftJoin("order_items", "order_items.order_id", "=", "orders.id")
            ->groupBy("orders.id")
            ->orderBy("orders.id",$dto->order_by)
            ->where('orders.business_id',$dto->business_id);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::QUERY,
                timing: HookTiming::ON,
                payload: [
                    'data' => $data,
                    'query' => $list
                ],
                module: 'Order'
            )
        );
        $list = $data['query'];
        $data = $data['data'];
        if ($dto->status) {
            $list = $list->where('orders.status', $dto->status);
        }
        if ($dto->keywords) {
            $list = $list->where('orders.order_no', 'like', '%' . $dto->keywords . '%');
        }
        return $list->paginate(15)->toArray();
    }
}