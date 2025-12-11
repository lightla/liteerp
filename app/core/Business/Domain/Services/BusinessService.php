<?php

namespace Core\Business\Domain\Services;

use App\Exceptions\BadException;
use Core\Business\Application\DTOs\CreateBusinessRequest;
use Core\Business\Domain\Entities\Business;

interface BusinessService
{
    public function create(array $data): Business;
    public function index(int $user_id): array;
    public function show(array $data): array | BadException;
    public function update(array $data): Business;
}