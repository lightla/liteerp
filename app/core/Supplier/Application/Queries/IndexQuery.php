<?php

namespace Core\Supplier\Application\Queries;

use App\Contracts\Queries\QueryInterface;
use App\Models\SupplierModel;
use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Supplier\Application\DTOs\IndexSupplierRequest;
use Illuminate\Support\Facades\Event;

class IndexQuery implements QueryInterface
{
    function __construct(
        private HookDispatcher $hooks
    ) {}
    public function handle(array $data): array
    {
        
        $dto = IndexSupplierRequest::fromArray($data);
        Event::dispatch("erp.supplier.index", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        $list = SupplierModel::select("suppliers.*")
        ->where('suppliers.business_id', $dto->business_id);
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::INDEX,
                phase: HookPhase::QUERY,
                timing: HookTiming::ON,
                payload: [
                    'query' => $list,
                    'data' => $data
                ],
                module: 'Supplier'
            )
        );
        $list = $data['query'];
        if (isset($dto->active)) {
            $list = $list->where('suppliers.active', $dto->active);
        }
        if (!empty($dto->keywords)) {
            $list = $list->where('suppliers.unit_name', 'like', '%' . $dto->keywords . '%');
        }
        
        return $list->orderBy('suppliers.id', $dto->order_by)->paginate(15)->toArray();
    }
}
