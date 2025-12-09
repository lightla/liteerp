<?php

namespace Core\Warehouse\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\Warehouse\Application\DTOs\CreateWarehouseRequest;
use Core\Warehouse\Domain\Services\WarehouseService;
use Core\Warehouse\Domain\Repositories\WarehouseRepositoryInterface;
use Core\Warehouse\Domain\Entities\Warehouse;

class WarehouseServiceImpl implements WarehouseService
{
    public function __construct(private WarehouseRepositoryInterface $repo) {}

    public function create(array $data): Warehouse
    {

        $entity = Warehouse::fromArray($data);
        if ($this->repo->checkNameExists($entity)) {
            throw new BadException(__("Name has been used"));
        }
        return $this->repo->create($entity);
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function show(array $data): Warehouse
    {
        $data = $this->repo->findById($data);
        if (!$data) {
            throw new BadException(__("Not found warehouse"));
        }
        return $data;
    }
    public function update(array $data): Warehouse
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        if ($entity->name !== $data['name']) {
            if ($this->repo->checkNameExists($entity)) {
                throw new BadException(__("Name has been used"));
            }
        }
        $entity->name = $data['name'];
        $entity->address = $data['address'];
        $entity->active = $data['active'];
        return $this->repo->update($entity);
    }
}
