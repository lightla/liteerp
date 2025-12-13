<?php

namespace Core\InvoiceIn\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\InvoiceIn\Domain\Services\InvoiceInService;
use Core\InvoiceIn\Domain\Repositories\InvoiceInRepositoryInterface;
use Core\InvoiceIn\Domain\Entities\InvoiceIn;

class InvoiceInServiceImpl implements InvoiceInService
{
    public function __construct(private InvoiceInRepositoryInterface $repo) {}

    public function create(array $data): InvoiceIn
    {
        $entity = InvoiceIn::fromArray($data);
        if(!$entity->document_no) {
            $entity->makeDocumentNo();
        }
        return $this->repo->create($entity);
    }
    public function index(array $data): array
    {
        return $this->repo->all($data);
    }
    public function update(array $data): InvoiceIn | BadException
    {
        $entity = $this->repo->findById($data);
        if (!$entity) {
            throw new BadException(__("Not found data"));
        }
        if ($data['approved'] === false && $entity->isApproved()) {
            throw new BadException(__("The data for stock in has been created, 
                    so you can change this invoice to unapprove. 
                    But you can request Purchase Department cancel purchase"));
        }
        $entity->invoice_date = $data['invoice_date'] ?? $entity->invoice_date;
        $entity->approved_by = $data['approved_by'] ?? $entity->approved_by;
        $entity->document_no = $data['document_no'] ?? $entity->document_no;
        $entity->due_date = $data['due_date'] ?? $entity->due_date;
        $entity->approved = $data['approved'] ?? $entity->approved;
        $entity->payment_status = $data['payment_status'] ?? $entity->payment_status;
        $entity->image = $data['image'] ?? $entity->image;
        $update = $this->repo->update($entity);
        return $update;
    }
    public function show(array $data): array | BadException
    {
        return $this->repo->findByIdWithFullData($data) ?? throw new BadException(__("Not found invoice"));
    }
    public function getById(array $data): ?InvoiceIn
    {
        return $this->repo->findById($data);
    }
    public function getByPurchaseId(array $data): ?InvoiceIn
    {
        return $this->repo->findByPurchaseId($data);
    }
    public function findById(array $data): InvoiceIn | BadException
    {
        return $this->repo->findById($data) ?? throw new BadException(__("Not found invoice in"));
    }
    /**
     * While order change status cancel then invoice in listen and change to unapproved
     */
    public function changeToUnApproved(array $data): InvoiceIn|BadException{
        $entity = $this->repo->findByPurchaseId($data);
        if (!$entity) {
            throw new BadException(__("Not found data"));
        }
        $entity->markUnApproved();
        $update = $this->repo->update($entity);
        return $update;
    }
}
