<?php

namespace Core\Warehouse\Http\Controllers;

use Core\Warehouse\Application\UseCases\CreateWarehouse;
use Core\Warehouse\Application\DTOs\CreateWarehouseRequest;
use Core\Warehouse\Application\DTOs\IndexWarehouseRequest as DTOsIndexWarehouseRequest;
use Core\Warehouse\Application\DTOs\ShowWarehouseRequest as DTOsShowWarehouseRequest;
use Core\Warehouse\Application\UseCases\IndexWarehouse;
use Core\Warehouse\Application\UseCases\ShowWarehouse;
use Core\Warehouse\Application\UseCases\UpdateWarehouse;
use Core\Warehouse\Http\Requests\CreateWarehouseRequest as FormRequest;
use Core\Warehouse\Http\Requests\IndexWarehouseRequest;
use Core\Warehouse\Http\Requests\ShowWarehouseRequest;
use Core\Warehouse\Http\Requests\UpdateWarehouseRequest;

class WarehouseController
{
    function __construct()
    {
        
    }
    public function store(FormRequest $request,CreateWarehouse $useCase)
    {
        $dto = CreateWarehouseRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexWarehouseRequest $request,IndexWarehouse $useCase){
        $dto = DTOsIndexWarehouseRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function show(string $id, ShowWarehouse $useCase, ShowWarehouseRequest $request) {
        $request->merge(['id' => $id]);
        $dto = DTOsShowWarehouseRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(string $id,UpdateWarehouse $useCase,UpdateWarehouseRequest $request) {
        $request->merge(['id' => $id]);
        $dto = CreateWarehouseRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}