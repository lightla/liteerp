<?php

namespace Core\Overview\Application\UseCases;

use Core\Overview\Domain\Services\OverviewService;
use Illuminate\Support\Facades\Concurrency;

class CreateOverview
{
    public function __construct(private OverviewService $service) {}

    public function handle()
    {
        Concurrency::driver('fork')->run([
            fn () => $this->service->createCacheForMonth(),
            fn () => $this->service->createCacheForYear()
        ]);
        return [];
    }
}
