<?php

namespace Core\Business\Application\UseCases;

use Core\Business\Application\DTOs\CreateBusinessRequest;
use Core\Business\Domain\Services\BusinessService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class UpdateBusiness
{
    public function __construct(private BusinessService $service) {}

    public function handle(CreateBusinessRequest $dto)
    {
        DB::beginTransaction();
        $business = $this->service->update($dto->toArray());
        Event::dispatch('erp.business.update',[
            'id' => $dto->id,
            'business_id' => $business->id,
            'user_id' => $dto->user_id
        ]);
        DB::commit();
        return $business;
    }
}