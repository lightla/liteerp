<?php

namespace Core\Overview\Domain\Services;

use Core\Overview\Domain\Entities\Overview;

interface OverviewService
{
    public function index(array $data): array;
    public function createCacheForMonth(): array;
    public function createCacheForYear(): array;
}