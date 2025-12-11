<?php

namespace Core\StockOut\Http\Controllers;

use Core\StockOut\Application\UseCases\CreateStockOut;
use Core\StockOut\Application\DTOs\CreateStockOutRequest;
use Core\StockOut\Application\DTOs\IndexStockOutRequest as DTOsIndexStockOutRequest;
use Core\StockOut\Application\UseCases\IndexStockOut;
use Core\StockOut\Application\UseCases\ShowStockOut;
use Core\StockOut\Application\UseCases\UpdateStockOut;
use Core\StockOut\Http\Requests\CreateStockOutRequest as FormRequest;
use Core\StockOut\Http\Requests\IndexStockOutRequest;
use Core\StockOut\Http\Requests\ShowStockOutRequest;
use Core\StockOut\Http\Requests\UpdateStockOutRequest;

class StockOutController
{
    public function store(FormRequest $request, CreateStockOut $useCase)
    {
        $dto = CreateStockOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexStockOutRequest $request, IndexStockOut $useCase)
    {
        $dto = DTOsIndexStockOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(string $id, UpdateStockOut $useCase, UpdateStockOutRequest $request)
    {
        $request->merge(['id' => $id]);
        $dto = CreateStockOutRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function show(
        string $id,
        ShowStockOut $useCase,
        ShowStockOutRequest $request
    ) {
        $request->merge(['id' => $id]);
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
}
