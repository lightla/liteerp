<?php

namespace Core\CustomInvoiceOut\Domain\Repositories;

use Core\CustomInvoiceOut\Domain\Entities\CustomInvoiceOut;

interface CustomInvoiceOutRepositoryInterface
{
    public function create(CustomInvoiceOut $entity): CustomInvoiceOut;
    public function index(array $data) : array;
    public function update(CustomInvoiceOut $entity): CustomInvoiceOut;
    public function findById(array $data) : ?CustomInvoiceOut;
    public function delete(CustomInvoiceOut $entity): CustomInvoiceOut;
    public function findDocumentNo(array $data) : ?CustomInvoiceOut;
}