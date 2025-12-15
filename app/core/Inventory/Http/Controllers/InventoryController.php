<?php

namespace Core\Inventory\Http\Controllers;

use Core\Inventory\Application\UseCases\CreateInventory;
use Core\Inventory\Application\DTOs\CreateInventoryRequest;
use Core\Inventory\Application\DTOs\IndexInventoryRequest as DTOsIndexInventoryRequest;
use Core\Inventory\Application\UseCases\IndexInventory;
use Core\Inventory\Http\Requests\CreateInventoryRequest as FormRequest;
use Core\Inventory\Http\Requests\IndexInventoryRequest;

class InventoryController
{
    public function store(FormRequest $request, CreateInventory $useCase)
    {
        $dto = CreateInventoryRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexInventory $useCase,
        IndexInventoryRequest $request) {
            $dto = DTOsIndexInventoryRequest::fromArray($request->all());
            $entity = $useCase->handle($dto);
            return response()->json(['message' => $entity]);
        }
}