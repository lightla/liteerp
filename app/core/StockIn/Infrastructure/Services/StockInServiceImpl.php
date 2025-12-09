<?php

namespace Core\StockIn\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\StockIn\Domain\Services\StockInService;
use Core\StockIn\Domain\Repositories\StockInRepositoryInterface;
use Core\StockIn\Domain\Entities\StockIn;
use Illuminate\Support\Facades\Log;

class StockInServiceImpl implements StockInService
{
    public function __construct(private StockInRepositoryInterface $repo) {}

    public function create(array $data): StockIn | BadException
    {
        $entity = StockIn::fromArray($data);
        $entity->markPending();
        return $this->repo->create($entity);
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function show(array $data): array | BadException
    {
        return $this->repo->show($data) ?? throw new BadException(__("Not found inventory"));
    }
    public function update(array $data) :StockIn | BadException {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        if($entity->isReceived()) {
            throw new BadException(__("This ticket got approved"));
        }
        if(!$entity->isReceived()) {
            $entity->status = $data['status'] ?? $entity->status;
        }
        $entity->approved_by ??= $data['approved_by'] ?? null;
        $entity->import_date = $data['import_date'] ?? $entity->import_date;
        return $this->repo->update($entity); 
    }
    public function changeToCancelled(array $data) :StockIn | BadException {
        $entity = $this->repo->findByInvoiceInId($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        $entity->markCancelled();
        return $this->repo->update($entity); 
    }
    public function findById(array $data): StockIn|BadException
    {
        return $this->repo->findById($data) ?? throw new BadException(__("Not found stock in"));
    }
}