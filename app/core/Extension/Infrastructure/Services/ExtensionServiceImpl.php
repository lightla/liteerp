<?php

namespace Core\Extension\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\Extension\Domain\Services\ExtensionService;
use Core\Extension\Domain\Repositories\ExtensionRepositoryInterface;
use Core\Extension\Domain\Entities\Extension;

class ExtensionServiceImpl implements ExtensionService
{
    public function __construct(private ExtensionRepositoryInterface $repo) {}

    public function create(array $data): array | BadException
    {
        return $this->repo->create($data) ?? throw new BadException(__("Add extension error"));
    }
    public function update(array $data): Extension | BadException
    {
        $entity = $this->repo->findByDirectory($data);
        if(!$entity) {
            throw new BadException(__("Not found extension error"));
        }
        return $this->repo->update($entity) ?? throw new BadException(__("Update extension error"));
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function delete(array $data): Extension|BadException
    {
        $entity = $this->repo->findByDirectory($data);
        if(!$entity) {
            throw new BadException(__("Not found extension error"));
        }
        return $this->repo->delete($entity);
    }
}