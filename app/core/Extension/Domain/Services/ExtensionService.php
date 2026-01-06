<?php

namespace Core\Extension\Domain\Services;

use App\Exceptions\BadException;
use Core\Extension\Domain\Entities\Extension;

interface ExtensionService
{
    public function create(array $data): array | BadException;
    public function update(array $data): Extension | BadException;
    public function delete(array $data): Extension | BadException;
    public function index(array $data): array;
}