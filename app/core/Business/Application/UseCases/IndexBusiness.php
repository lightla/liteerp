<?php

namespace Core\Business\Application\UseCases;

use Core\Business\Application\DTOs\IndexBusinessRequest;
use Core\Business\Domain\Services\BusinessService;
use Illuminate\Support\Facades\Auth;

class IndexBusiness
{
    public function __construct(private BusinessService $service) {}

    public function handle()
    {
        $user = Auth::guard('sanctum')->user();
        return $this->service->index($user->id);
    }
}