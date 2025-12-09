<?php

namespace Core\Warehouse\Application\UseCases;

use App\Exceptions\UnauthorizedException;
use Core\Warehouse\Application\DTOs\CreateWarehouseRequest;
use Core\Warehouse\Application\DTOs\ShowWarehouseRequest;
use Core\Warehouse\Domain\Services\WarehouseService;
use Illuminate\Support\Facades\Event;

class ShowWarehouse
{
    public function __construct(private WarehouseService $service) {}

    public function handle(ShowWarehouseRequest $dto)
    {
        $show = $this->service->show($dto->toArray());
        Event::dispatch('erp.warehouse.show',[
            'user_id' => $dto->created_by,
            'business_id' => $dto->busuness_id
        ]);
        return $show;
    }
}
