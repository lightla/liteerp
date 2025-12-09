<?php

namespace Core\PurchaseItem\Http\Controllers;

use Core\PurchaseItem\Application\UseCases\CreatePurchaseItem;
use Core\PurchaseItem\Application\DTOs\CreatePurchaseItemRequest;
use Core\PurchaseItem\Application\UseCases\IndexPurchaseItem;
use Core\PurchaseItem\Application\UseCases\UpdatePurchaseItem;
use Core\PurchaseItem\Http\Requests\CreatePurchaseItemRequest as FormRequest;
use Core\PurchaseItem\Http\Requests\IndexPurchaseItemRequest;
use Core\PurchaseItem\Http\Requests\UpdatePurchaseItemRequest;

class PurchaseItemController
{
    public function store(FormRequest $request, CreatePurchaseItem $useCase)
    {
        $dto = CreatePurchaseItemRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexPurchaseItemRequest $request,IndexPurchaseItem $useCase) {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function update(string $id,
        UpdatePurchaseItemRequest $request,
        UpdatePurchaseItem $useCase) {
            $request->merge(['id' => $id]);
            $dto = CreatePurchaseItemRequest::fromArray($request->all());
            $entity = $useCase->handle($dto);
            return response()->json(['message' => $entity]);
        }
}