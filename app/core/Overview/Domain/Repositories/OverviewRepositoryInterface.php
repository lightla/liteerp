<?php

namespace Core\Overview\Domain\Repositories;

use Core\Overview\Domain\Entities\Overview;

interface OverviewRepositoryInterface
{
    public function getCustomer(array $data): int;
    public function getRevenue(array $data): int;
    public function getOrder(array $data): int;
    public function getProduct(array $data): int;
    public function businessChart(array $data) : array;
    public function createCacheForMonth(array $data): array;
    public function getCacheForMonth(): ?array;
    public function createCacheForYear(array $data): array;
    public function getCacheForYear(): ?array;
}