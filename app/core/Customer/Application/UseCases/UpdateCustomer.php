<?php

namespace Core\Customer\Application\UseCases;

use Core\Customer\Application\DTOs\CreateCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateCustomer
{
    public function __construct(private CustomerService $service) {}

    public function handle(array $data)
    {
        DB::beginTransaction();
        $dto = CreateCustomerRequest::fromArray($data);
        $update = $this->service->update($dto->toArray());
        Event::dispatch("erp.customer.update", [
            ...$update->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $update;
    }
}