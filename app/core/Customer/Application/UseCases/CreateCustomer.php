<?php

namespace Core\Customer\Application\UseCases;

use Core\Customer\Application\DTOs\CreateCustomerRequest;
use Core\Customer\Domain\Services\CustomerService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateCustomer
{
    public function __construct(
        private CustomerService $service
    ) {}

    public function handle(CreateCustomerRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.customer.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}
