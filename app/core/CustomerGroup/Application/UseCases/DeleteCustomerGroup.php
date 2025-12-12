<?php

namespace Core\CustomerGroup\Application\UseCases;

use Core\CustomerGroup\Application\DTOs\DeleteCustomerGroupRequest;
use Core\CustomerGroup\Domain\Services\CustomerGroupService;
use Illuminate\Support\Facades\Event;

class DeleteCustomerGroup
{
    public function __construct(private CustomerGroupService $service) {}

    public function handle(DeleteCustomerGroupRequest $dto)
    {
        Event::dispatch("erp.customergroup.delete", [
            ...$dto->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $this->service->delete($dto->toArray());
    }
}