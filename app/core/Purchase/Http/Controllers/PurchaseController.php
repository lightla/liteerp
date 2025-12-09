<?php

namespace Core\Purchase\Http\Controllers;

use Core\Purchase\Application\UseCases\CreatePurchase;
use Core\Purchase\Application\DTOs\CreatePurchaseRequest;
use Core\Purchase\Application\DTOs\UpdatePurchaseRequest as DTOsUpdatePurchaseRequest;
use Core\Purchase\Application\UseCases\IndexPurchase;
use Core\Purchase\Application\UseCases\ShowPurchase;
use Core\Purchase\Application\UseCases\UpdatePurchase;
use Core\Purchase\Http\Requests\CreatePurchaseRequest as FormRequest;
use Core\Purchase\Http\Requests\IndexPurchaseRequest;
use Core\Purchase\Http\Requests\ShowPurchaseRequest;
use Core\Purchase\Http\Requests\UpdatePurchaseRequest;

class PurchaseController
{
    public function store(FormRequest $request, CreatePurchase $useCase)
    {
        $dto = CreatePurchaseRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexPurchaseRequest $request, IndexPurchase $useCase){
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function show(ShowPurchaseRequest $request, ShowPurchase $useCase, string $id) {
        $request->merge(['id' => $id]);
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function update(string $id,UpdatePurchaseRequest $request,UpdatePurchase $useCacse) {
        $request->merge(['id' => $id]);
        $dto = DTOsUpdatePurchaseRequest::fromArray($request->all());
        $entity = $useCacse->handle($dto);
        return response()->json(['message' => $entity]);
    }
}