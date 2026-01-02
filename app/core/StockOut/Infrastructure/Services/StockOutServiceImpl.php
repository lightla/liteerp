<?php

namespace Core\StockOut\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\StockOut\Domain\Services\StockOutService;
use Core\StockOut\Domain\Repositories\StockOutRepositoryInterface;
use Core\StockOut\Domain\Entities\StockOut;

class StockOutServiceImpl implements StockOutService
{
    public function __construct(private StockOutRepositoryInterface $repo) {}

    public function create(array $data): StockOut
    {
        $entity = StockOut::fromArray($data);
        $entity->removeApprovedBy();
        $entity->markPending();
        return $this->repo->create($entity);
    }
    public function update(array $data): StockOut|BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        if($data['status'] === 'shipped') {
            if(!$entity->isPending()) {
                throw new BadException(__("Status invalid"));
            }
        }
        if($data['status'] === 'completed') {
            if(!$entity->isShipped()) {
                throw new BadException(__("Status invalid"));
            }
        }
        if($data['status'] === 'cancelled') {
            if($entity->isCompleted()) {
                throw new BadException(__("Status invalid"));
            }
        }
        $entity->status = $data['status'];
        return $this->repo->update($entity);
    }
    public function show(array $data): array
    {
        return $this->repo->findByIdWithFullData($data);
    }
    public function findById(array $data): StockOut | BadException
    {
        return $this->repo->findById($data) ?? throw new BadException(__("Not found data"));
    }
    public function getById(array $data): ?StockOut
    {
        return $this->repo->findById($data);
    }
    public function getByInvoiceInId(array $data) : ?StockOut {
        return $this->repo->getByInvoiceInId($data);
    }
}