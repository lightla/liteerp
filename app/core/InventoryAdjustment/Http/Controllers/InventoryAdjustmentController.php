<?php

namespace Core\InventoryAdjustment\Http\Controllers;

use Core\InventoryAdjustment\Application\UseCases\CreateInventoryAdjustment;
use Core\InventoryAdjustment\Application\DTOs\CreateInventoryAdjustmentRequest;
use Core\InventoryAdjustment\Application\UseCases\IndexInventoryAdjustment;
use Core\InventoryAdjustment\Http\Requests\CreateInventoryAdjustmentRequest as FormRequest;
use Core\InventoryAdjustment\Http\Requests\IndexInventoryAdjustmentRequest;

class InventoryAdjustmentController
{
    public function store(FormRequest $request, CreateInventoryAdjustment $useCase)
    {
        $dto = CreateInventoryAdjustmentRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexInventoryAdjustmentRequest $request, 
    IndexInventoryAdjustment $useCase)
    {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
}