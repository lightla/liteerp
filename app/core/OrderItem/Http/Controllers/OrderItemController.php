<?php

namespace Core\OrderItem\Http\Controllers;

use Core\OrderItem\Application\UseCases\CreateOrderItem;
use Core\OrderItem\Application\DTOs\CreateOrderItemRequest;
use Core\OrderItem\Application\UseCases\IndexOrderItem;
use Core\OrderItem\Application\UseCases\UpdateOrderItem;
use Core\OrderItem\Http\Requests\CreateOrderItemRequest as FormRequest;
use Core\OrderItem\Http\Requests\IndexOrderItemRequest;
use Core\OrderItem\Http\Requests\UpdateOrderItemRequest;

class OrderItemController
{
    public function store(FormRequest $request, CreateOrderItem $useCase)
    {
        $dto = CreateOrderItemRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexOrderItemRequest $request, IndexOrderItem $useCase){
        $entity = $useCase->handle($request->toArray());
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateOrderItemRequest $request,UpdateOrderItem $useCase,string $id) {
        $request->merge(['id' => $id]);
        $dto = CreateOrderItemRequest::fromArray($request->all());
        $entity = $useCase->handle($dto->toArray());
        return response()->json(['message' => $entity]);
    }
}