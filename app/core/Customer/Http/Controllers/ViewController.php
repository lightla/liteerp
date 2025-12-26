<?php

namespace Core\Customer\Http\Controllers;

use Core\Customer\Application\UseCases\CreateCustomer;
use Core\Customer\Application\DTOs\CreateCustomerRequest;
use Core\Customer\Application\DTOs\DeleteCustomerRequest as DTOsDeleteCustomerRequest;
use Core\Customer\Application\DTOs\IndexCustomerRequest as DTOsIndexCustomerRequest;
use Core\Customer\Application\UseCases\DeleteCustomer;
use Core\Customer\Application\UseCases\IndexCustomer;
use Core\Customer\Application\UseCases\UpdateCustomer;
use Core\Customer\Http\Requests\CreateCustomerRequest as FormRequest;
use Core\Customer\Http\Requests\DeleteCustomerRequest;
use Core\Customer\Http\Requests\IndexCustomerRequest;
use Core\Customer\Http\Requests\UpdateCustomerRequest;

class ViewController
{
    public function store(FormRequest $request, CreateCustomer $useCase)
    {
        $dto = CreateCustomerRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexCustomerRequest $request, IndexCustomer $useCase) {
        $dto = DTOsIndexCustomerRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateCustomerRequest $request,UpdateCustomer $useCase,string $id) {
        $request->merge(['id' => $id]);
        $dto = CreateCustomerRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function destroy(DeleteCustomerRequest $request,DeleteCustomer $useCase,string $id) {
        $request->merge(['id' => $id]);
        $dto = DTOsDeleteCustomerRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}