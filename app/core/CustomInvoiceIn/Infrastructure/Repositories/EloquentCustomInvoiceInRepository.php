<?php

namespace Core\CustomInvoiceIn\Infrastructure\Repositories;

use App\Models\CustomInvoiceInModel;
use Core\CustomInvoiceIn\Domain\Repositories\CustomInvoiceInRepositoryInterface;
use Core\CustomInvoiceIn\Domain\Entities\CustomInvoiceIn;

class EloquentCustomInvoiceInRepository implements CustomInvoiceInRepositoryInterface
{
    public function create(CustomInvoiceIn $entity): CustomInvoiceIn
    {
        $create = CustomInvoiceInModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function update(CustomInvoiceIn $entity): CustomInvoiceIn
    {
        CustomInvoiceInModel::where('id',$entity->id)
        ->update($entity->toArray());
        return $entity;
    }
    public function findByDocumentNo(array $data): ?CustomInvoiceIn
    {
        $row = CustomInvoiceInModel::where('document_no',$data['document_no'])
        ->where('business_id',$data['business_id'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        return CustomInvoiceIn::fromArray($row);
    }
    public function findById(array $data): ?CustomInvoiceIn
    {
        $row = CustomInvoiceInModel::where('id',$data['id'])
        ->where('business_id',$data['business_id'])
        ->first()?->toArray();
        if(!$row) {
            return null;
        }
        return CustomInvoiceIn::fromArray($row);
    }
    public function index(array $data): array
    {
        $index = CustomInvoiceInModel::select("custom_invoice_ins.*",
            "suppliers.unit_name as unit_name")
        ->join("suppliers","suppliers.id","=","custom_invoice_ins.supplier_id")
        ->where('custom_invoice_ins.business_id',$data['business_id']);
        if(!empty($data['keywords'])) {
            $index = $index->where('custom_invoice_ins.document_no','like',
                '%'. $data['keywords'] .'%');
        }
        if(!empty($data['payment_status'])) {
            $index = $index->where('custom_invoice_ins.payment_status',
            $data['payment_status']);
        }
        return $index->orderBy("custom_invoice_ins.id",$data['order_by'])->paginate(15)->toArray();
    }
    public function delete(CustomInvoiceIn $entity): CustomInvoiceIn
    {
        CustomInvoiceInModel::where('id',$entity->id)
        ->delete();
        return $entity;
    }
}