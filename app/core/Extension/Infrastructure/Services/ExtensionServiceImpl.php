<?php

namespace Core\Extension\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\Extension\Domain\Services\ExtensionService;
use Core\Extension\Domain\Repositories\ExtensionRepositoryInterface;
use Core\Extension\Domain\Entities\Extension;

class ExtensionServiceImpl implements ExtensionService
{
    public function __construct(private ExtensionRepositoryInterface $repo) {}

    public function create(array $data): Extension | BadException
    {
        $entity = $this->repo->create($data);
        if(!$entity) {
            throw new BadException(__("Add extension error"));
        }
        return $entity;
    }
    public function update(array $data): Extension | BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found extension error"));
        }
        $entity->switchStatus();
        return $this->repo->update($entity) ?? throw new BadException(__("Update extension error"));
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function delete(array $data): Extension|BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found extension error"));
        }
        return $this->repo->delete($entity);
    }
    public function findById(array $data): Extension|BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found extension error"));
        }
        return $entity;
    }
    public function all(): array
    {
        return $this->repo->all();
    }
}