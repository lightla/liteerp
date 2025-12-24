<?php

namespace Core\Overview\Application\UseCases;

use Core\Business\Application\UseCases\AllBusiness;
use Core\Overview\Application\DTOs\CreateOverviewRequest;
use Core\Overview\Domain\Services\OverviewService;
use Illuminate\Support\Facades\Concurrency;

class CreateOverview
{
    public function __construct(private OverviewService $service) {}

    public function handle(AllBusiness $AllBusiness)
    {
        foreach ($AllBusiness->handle() as $key => $value) {
            $dto = CreateOverviewRequest::fromArray(['business_id' => $value['id']]);
            if (env('ENV') !== 'production') {
                $this->service->createCacheForMonth($dto->toArray());
                $this->service->createCacheForYear($dto->toArray());
                $this->service->createRevenueByTime($dto->toArray());
                $this->service->createExpenseByTime($dto->toArray());
            } else {
                Concurrency::driver('fork')->run([
                    fn() => $this->service
                        ->createCacheForMonth($dto->toArray()),
                    fn() => $this->service->createCacheForYear($dto->toArray()),
                    fn() => $this->service->createRevenueByTime($dto->toArray()),
                    fn() => $this->service->createExpenseByTime($dto->toArray())
                ]);
            }
        }
        return [];
    }
}
