<?php

namespace Core\CustomInvoiceOut\Infrastructure\Repositories;

use App\Models\CustomInvoiceOutModel;
use Core\CustomInvoiceOut\Domain\Repositories\CustomInvoiceOutRepositoryInterface;
use Core\CustomInvoiceOut\Domain\Entities\CustomInvoiceOut;

class EloquentCustomInvoiceOutRepository implements CustomInvoiceOutRepositoryInterface
{
    public function create(CustomInvoiceOut $entity): CustomInvoiceOut
    {
        $create = CustomInvoiceOutModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function update(CustomInvoiceOut $entity): CustomInvoiceOut
    {
        CustomInvoiceOutModel::where('id',$entity->id)
        ->update($entity->toArray());
        return $entity;
    }
    public function index(array $data): array
    {
        return CustomInvoiceOutModel::select("custom_invoice_outs.*",
            "customers.name as customer_name")
        ->join("customers","customers.id","=","custom_invoice_outs.customer_id")
        ->where('custom_invoice_outs.business_id',$data['business_id'])
        ->paginate(15)->toArray();
    }
    public function findById(array $data): ?CustomInvoiceOut
    {
        $row = CustomInvoiceOutModel::where('id',$data['id'])
        ->where('business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return null;
        }
        return CustomInvoiceOut::fromArray($row);
    }
    public function delete(CustomInvoiceOut $entity): CustomInvoiceOut
    {
        CustomInvoiceOutModel::where('id',$entity->id)
        ->delete();
        return $entity;
    }
    public function findDocumentNo(array $data): ?CustomInvoiceOut
    {
        $row = CustomInvoiceOutModel::where('document_no',$data['document_no'])
        ->where('business_id',$data['business_id'])->first()?->toArray();
        if(!$row) {
            return null;
        }
        return CustomInvoiceOut::fromArray($row);
    }
}