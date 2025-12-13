<?php

namespace Core\Overview\Domain\Services;

use Core\Overview\Domain\Entities\Overview;

interface OverviewService
{
    public function create(array $data): Overview;
}