<?php

namespace Core\Shipping\Application\UseCases;

use Core\Shipping\Application\DTOs\CreateShippingRequest;
use Core\Shipping\Domain\Services\ShippingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
class CreateShipping
{
    public function __construct(private ShippingService $service) {}

    public function handle(CreateShippingRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.shipping.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}