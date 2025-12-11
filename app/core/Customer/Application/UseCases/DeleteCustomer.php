<?php

namespace Core\Customer\Application\UseCases;

use Core\Customer\Application\DTOs\DeleteCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteCustomer
{
    public function __construct(private CustomerService $service) {}

    public function handle(DeleteCustomerRequest $dto)
    {
        DB::beginTransaction();
        $update = $this->service->delete($dto->toArray());
        Event::dispatch("erp.customer.delete", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}