<?php

namespace Core\CustomInvoiceOut\Http\Controllers;

use Core\CustomInvoiceOut\Application\UseCases\CreateCustomInvoiceOut;
use Core\CustomInvoiceOut\Application\DTOs\CreateCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Application\DTOs\DeleteCustomInvoiceOutRequest as DTOsDeleteCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Application\DTOs\IndexCustomInvoiceOutRequest as DTOsIndexCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Application\UseCases\DeleteCustomInvoiceOut;
use Core\CustomInvoiceOut\Application\UseCases\IndexCustomInvoiceOut;
use Core\CustomInvoiceOut\Application\UseCases\UpdateCustomInvoiceOut;
use Core\CustomInvoiceOut\Http\Requests\CreateCustomInvoiceOutRequest as FormRequest;
use Core\CustomInvoiceOut\Http\Requests\DeleteCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Http\Requests\IndexCustomInvoiceOutRequest;
use Core\CustomInvoiceOut\Http\Requests\UpdateCustomInvoiceOutRequest;

class CustomInvoiceOutController
{
    public function store(FormRequest $request, CreateCustomInvoiceOut $useCase)
    {
        $dto = CreateCustomInvoiceOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexCustomInvoiceOutRequest $request, IndexCustomInvoiceOut $useCase)
    {
        $dto = DTOsIndexCustomInvoiceOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateCustomInvoiceOutRequest $request, 
        UpdateCustomInvoiceOut $useCase,string $id)
    {
        $request->merge(['id' => $id]);
        $dto = CreateCustomInvoiceOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function destroy(DeleteCustomInvoiceOutRequest $request, 
        DeleteCustomInvoiceOut $useCase,string $id)
    {
        $request->merge(['id' => $id]);
        $dto = DTOsDeleteCustomInvoiceOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}