<?php

namespace Core\Supplier\Http\Controllers;

use Core\Supplier\Application\UseCases\CreateSupplier;
use Core\Supplier\Application\DTOs\CreateSupplierRequest;
use Core\Supplier\Application\DTOs\IndexSupplierRequest as DTOsIndexSupplierRequest;
use Core\Supplier\Application\UseCases\IndexSupplier;
use Core\Supplier\Application\UseCases\UpdateSupplier;
use Core\Supplier\Http\Requests\CreateSupplierRequest as FormRequest;
use Core\Supplier\Http\Requests\IndexSupplierRequest;
use Core\Supplier\Http\Requests\UpdateSupplierRequest;

class SupplierController
{
    public function index(IndexSupplierRequest $request, IndexSupplier $useCase){
        $dto = DTOsIndexSupplierRequest::fromArray($request->all()); 
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function store(FormRequest $request, CreateSupplier $useCase)
    {
        $dto = CreateSupplierRequest::fromArray($request->all()); 
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateSupplierRequest $request,UpdateSupplier $useCase,string $id) {
        $request->merge(['id' => $id]);
        $dto = CreateSupplierRequest::fromArray($request->all()); 
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}