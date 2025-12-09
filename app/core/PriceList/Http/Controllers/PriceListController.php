<?php

namespace Core\PriceList\Http\Controllers;

use Core\PriceList\Application\UseCases\CreatePriceList;
use Core\PriceList\Application\DTOs\CreatePriceListRequest;
use Core\PriceList\Application\UseCases\IndexPriceList;
use Core\PriceList\Application\UseCases\UpdatePriceList;
use Core\PriceList\Http\Requests\CreatePriceListRequest as FormRequest;
use Core\PriceList\Http\Requests\IndexPriceListRequest;
use Core\PriceList\Http\Requests\UpdatePriceListRequest;

class PriceListController
{
    public function store(FormRequest $request, CreatePriceList $useCase)
    {
        $dto = CreatePriceListRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function update(UpdatePriceListRequest $request, UpdatePriceList $useCase,string $id)
    {
        $request->merge(['id' => $id]);
        $dto = CreatePriceListRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexPriceListRequest $request, IndexPriceList $useCase)
    {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
}