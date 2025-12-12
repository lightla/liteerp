<?php

namespace Core\CustomerGroup\Http\Controllers;

use Core\CustomerGroup\Application\UseCases\CreateCustomerGroup;
use Core\CustomerGroup\Application\DTOs\CreateCustomerGroupRequest;
use Core\CustomerGroup\Application\DTOs\DeleteCustomerGroupRequest as DTOsDeleteCustomerGroupRequest;
use Core\CustomerGroup\Application\DTOs\IndexCustomerGroupRequest as DTOsIndexCustomerGroupRequest;
use Core\CustomerGroup\Application\DTOs\ShowCustomerGroupRequest;
use Core\CustomerGroup\Application\UseCases\DeleteCustomerGroup;
use Core\CustomerGroup\Application\UseCases\IndexCustomerGroup;
use Core\CustomerGroup\Application\UseCases\ShowCustomerGroup;
use Core\CustomerGroup\Application\UseCases\UpdateCustomerGroup;
use Core\CustomerGroup\Http\Requests\CreateCustomerGroupRequest as FormRequest;
use Core\CustomerGroup\Http\Requests\DeleteCustomerGroupRequest;
use Core\CustomerGroup\Http\Requests\IndexCustomerGroupRequest;
use Core\CustomerGroup\Http\Requests\ShowCustomerGroupRequest as RequestsShowCustomerGroupRequest;
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
        $dto = DTOsIndexCustomerGroupRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function show(
        RequestsShowCustomerGroupRequest $request,
        ShowCustomerGroup $useCase,
        string $id
    ) {
        $request->merge(['id' => $id]);
        $dto = ShowCustomerGroupRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function destroy(
        DeleteCustomerGroupRequest $request,
        DeleteCustomerGroup $useCase,
        string $id
    ) {
        $request->merge(['id' => $id]);
        $dto = DTOsDeleteCustomerGroupRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}
