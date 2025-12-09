<?php

namespace Core\Order\Http\Controllers;

use Core\Order\Application\UseCases\CreateOrder;
use Core\Order\Application\DTOs\CreateOrderRequest;
use Core\Order\Application\UseCases\IndexOrder;
use Core\Order\Application\UseCases\ShowOrder;
use Core\Order\Application\UseCases\UpdateOrder;
use Core\Order\Http\Requests\CreateOrderRequest as FormRequest;
use Core\Order\Http\Requests\IndexOrderRequest;
use Core\Order\Http\Requests\ShowOrderRequest;
use Core\Order\Http\Requests\UpdateOrderRequest;

class OrderController
{
    public function store(FormRequest $request, CreateOrder $useCase)
    {
        $dto = CreateOrderRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexOrderRequest $request, IndexOrder $useCase) {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function show(ShowOrderRequest $request, ShowOrder $useCase, string $id) {
        $request->merge(['id' => $id]);
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function update(string $id,UpdateOrderRequest $request,UpdateOrder $useCase) {
        $request->merge(['id' => $id]);
        $dto = CreateOrderRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}