<?php

namespace Core\StockMovementIn\Http\Controllers;

use Core\StockMovementIn\Application\UseCases\CreateStockMovementIn;
use Core\StockMovementIn\Application\DTOs\CreateStockMovementInRequest;
use Core\StockMovementIn\Application\DTOs\IndexStockMovementInRequest as DTOsIndexStockMovementInRequest;
use Core\StockMovementIn\Application\UseCases\IndexStockMovementIn;
use Core\StockMovementIn\Http\Requests\CreateStockMovementInRequest as FormRequest;
use Core\StockMovementIn\Http\Requests\IndexStockMovementInRequest;

class StockMovementInController
{
    public function store(FormRequest $request, CreateStockMovementIn $useCase)
    {
        $dto = CreateStockMovementInRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexStockMovementInRequest $request, 
        IndexStockMovementIn $useCase)
    {
        $dto = DTOsIndexStockMovementInRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}
