<?php

namespace Core\CustomInvoiceIn\Http\Controllers;

use Core\CustomInvoiceIn\Application\UseCases\CreateCustomInvoiceIn;
use Core\CustomInvoiceIn\Application\DTOs\CreateCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Application\DTOs\DeleteCustomInvoiceInRequest as DTOsDeleteCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Application\DTOs\IndexCustomInvoiceInRequest as DTOsIndexCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Application\UseCases\DeleteCustomInvoiceIn;
use Core\CustomInvoiceIn\Application\UseCases\IndexCustomInvoiceIn;
use Core\CustomInvoiceIn\Application\UseCases\UpdateCustomInvoiceIn;
use Core\CustomInvoiceIn\Http\Requests\CreateCustomInvoiceInRequest as FormRequest;
use Core\CustomInvoiceIn\Http\Requests\DeleteCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Http\Requests\IndexCustomInvoiceInRequest;
use Core\CustomInvoiceIn\Http\Requests\UpdateCustomInvoiceInRequest;

class CustomInvoiceInController
{
    public function store(FormRequest $request, CreateCustomInvoiceIn $useCase)
    {
        $dto = CreateCustomInvoiceInRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateCustomInvoiceInRequest $request, 
        UpdateCustomInvoiceIn $useCase, string $id)
    {
        $request->merge(['id' => $id]);
        $dto = CreateCustomInvoiceInRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexCustomInvoiceInRequest $request, 
        IndexCustomInvoiceIn $useCase)
    {
        $dto = DTOsIndexCustomInvoiceInRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function destroy(DeleteCustomInvoiceInRequest $request, 
        DeleteCustomInvoiceIn $useCase,string $id)
    {
        $request->merge(['id' => $id]);
        $dto = DTOsDeleteCustomInvoiceInRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}