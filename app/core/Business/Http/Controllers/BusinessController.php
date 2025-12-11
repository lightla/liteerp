<?php

namespace Core\Business\Http\Controllers;

use Core\Business\Application\UseCases\CreateBusiness;
use Core\Business\Application\DTOs\CreateBusinessRequest;
use Core\Business\Application\DTOs\ShowBusinessRequest as DTOsShowBusinessRequest;
use Core\Business\Application\UseCases\IndexBusiness;
use Core\Business\Application\UseCases\ShowBusiness;
use Core\Business\Application\UseCases\UpdateBusiness;
use Core\Business\Http\Requests\CreateBusinessRequest as FormRequest;
use Core\Business\Http\Requests\IndexBusinessRequest;
use Core\Business\Http\Requests\ShowBusinessRequest;
use Core\Business\Http\Requests\UpdateBusinessRequest;

class BusinessController
{
    public function index(IndexBusinessRequest $request, IndexBusiness $useCase) {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function store(FormRequest $request, CreateBusiness $useCase)
    {
        $dto = CreateBusinessRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function show(ShowBusinessRequest $request,string $id, ShowBusiness $useCase) {
        $request->merge(['id' => $id]);
        $dto = DTOsShowBusinessRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateBusinessRequest $request, UpdateBusiness $useCase,string $id)
    {
        $request->merge(['id' => $id]);
        $dto = CreateBusinessRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}