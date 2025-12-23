<?php

namespace Core\CustomInvoiceOut\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\CustomInvoiceOut\Domain\Services\CustomInvoiceOutService;
use Core\CustomInvoiceOut\Domain\Repositories\CustomInvoiceOutRepositoryInterface;
use Core\CustomInvoiceOut\Domain\Entities\CustomInvoiceOut;

class CustomInvoiceOutServiceImpl implements CustomInvoiceOutService
{
    public function __construct(private CustomInvoiceOutRepositoryInterface $repo) {}

    public function create(array $data): CustomInvoiceOut
    {
        if($this->repo->findDocumentNo($data)) {
            throw new BadException(__("Document no has been used"));
        }
        $entity = CustomInvoiceOut::fromArray($data);
        $entity->makeDocumentNo();
        return $this->repo->create($entity);
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function update(array $data): CustomInvoiceOut | BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity){
            throw new BadException(__("Not found custom invoice out"));
        }
        if($entity->document_no !== $data['document_no']) {
            if($this->repo->findDocumentNo($data)) {
                throw new BadException(__("Document no has been used"));
            }
        }
        $entity->description = $data['description'];
        $entity->amount = $data['amount'];
        $entity->invoice_date = $data['invoice_date'];
        $entity->approved = $data['approved'];
        $entity->payment_status = $data['payment_status'];
        $entity->document_no = $data['document_no'];
        $entity->makeDocumentNo();
        return $this->repo->update($entity);
    }
    public function delete(array $data): CustomInvoiceOut|BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity){
            throw new BadException(__("Not found custom invoice out"));
        }
        return $this->repo->delete($entity);
    }
}