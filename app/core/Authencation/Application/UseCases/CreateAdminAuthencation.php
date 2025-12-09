<?php

namespace Core\Authencation\Application\UseCases;

use Core\AppToken\Application\UseCases\CreateAppToken;
use Core\Authencation\Application\DTOs\CreateAuthencationRequest;
use Core\Authencation\Domain\Services\AuthencationService;
use Illuminate\Support\Facades\DB;

class CreateAdminAuthencation
{
    public function __construct(private AuthencationService $service) {}

    public function handle(CreateAuthencationRequest $dto)
    {
        DB::beginTransaction();
        $account = $this->service->createAdmin($dto->toArray());
        DB::commit();
        return $account;
    }
}