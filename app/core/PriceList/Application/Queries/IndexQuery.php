<?php 
namespace Core\PriceList\Application\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Models\PriceListModel;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\PriceList\Application\DTOs\IndexPriceListRequest;

class IndexQuery implements QueryInterface {
    function __construct(private HookDispatcher $hooks)
    {
        
    }
    public function handle(array $data): array
    {
        $dto = IndexPriceListRequest::fromArray($data);
        $rows = PriceListModel::select("price_list.*",
        "products.name as name",
        "customer_group.name as group")
        ->join("products","products.id","=","price_list.product_id")
        ->join("customer_group","customer_group.id",
            "=","price_list.customer_group_id")
        ->where("products.business_id",$dto->business_id);
        $hooks = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::QUERY,
                timing: HookTiming::ON,
                payload: [
                    'query' => $rows,
                    'data' => $data
                ],
                module: 'PriceList'
            )
        );
        $rows = $hooks['query'];
        if($dto->keywords) {
            $rows = $rows->where('products.name','like','%'.$dto->keywords.'%');
        }
        return $rows->paginate(15)->toArray();
    }
}