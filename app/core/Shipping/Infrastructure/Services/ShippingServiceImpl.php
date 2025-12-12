<?php

namespace Core\Shipping\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\Shipping\Domain\Services\ShippingService;
use Core\Shipping\Domain\Repositories\ShippingRepositoryInterface;
use Core\Shipping\Domain\Entities\Shipping;

class ShippingServiceImpl implements ShippingService
{
    public function __construct(private ShippingRepositoryInterface $repo) {}

    public function create(array $data): Shipping
    {
        $row = $this->repo->findByName($data);
        if($row) {
            throw new BadException(__("Name has been used"));
        }
        $entity = Shipping::fromArray($data);
        return $this->repo->create($entity);
    }
    public function show(array $data): Shipping | BadException
    {
        return $this->repo->findById($data) ?? throw new BadException(__("Not found data"));
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function update(array $data): Shipping | BadException
    {
        $row = $this->repo->findByName($data);
        if($row && $row->id !== $data['id']) {
            throw new BadException(__("Name has been used"));
        }
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        $entity->name = $data['name'];
        $entity->code = $data['code'];
        $entity->logo = $data['logo'] ?? null;
        $entity->active = $data['active'];
        return $this->repo->update($entity);
    }
    public function delete(array $data): Shipping | BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        return $this->repo->delete($entity);
    }
}