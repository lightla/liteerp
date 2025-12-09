<?php

namespace Core\CustomerGroup\Http\Controllers;

use Core\CustomerGroup\Application\UseCases\CreateCustomerGroup;
use Core\CustomerGroup\Application\DTOs\CreateCustomerGroupRequest;
use Core\CustomerGroup\Application\UseCases\IndexCustomerGroup;
use Core\CustomerGroup\Application\UseCases\UpdateCustomerGroup;
use Core\CustomerGroup\Http\Requests\CreateCustomerGroupRequest as FormRequest;
use Core\CustomerGroup\Http\Requests\IndexCustomerGroupRequest;
use Core\CustomerGroup\Http\Requests\UpdateCustomerGroupRequest;

class CustomerGroupController
{
    public function store(FormRequest $request, CreateCustomerGroup $useCase)
    {
        $dto = CreateCustomerGroupRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(
        UpdateCustomerGroupRequest $request,
        UpdateCustomerGroup $useCase,
        string $id
    ) {
        $request->merge(['id' => $id]);
        $dto = CreateCustomerGroupRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(
        IndexCustomerGroupRequest $request,
        IndexCustomerGroup $useCase
    ) {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function show(
        IndexCustomerGroupRequest $request,
        IndexCustomerGroup $useCase,
        string $id
    ) {
        $request->merge(['id' => $id]);
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
}
