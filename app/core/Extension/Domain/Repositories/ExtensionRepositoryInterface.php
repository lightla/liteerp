<?php

namespace Core\Extension\Domain\Repositories;

use Core\Extension\Domain\Entities\Extension;

interface ExtensionRepositoryInterface
{
    public function create(array $data): ?array;
    public function findByDirectory(array $data): ?Extension;
    public function update(Extension $data): ?Extension;
    public function delete(Extension $data): ?Extension;
    public function index(array $data): array;
}