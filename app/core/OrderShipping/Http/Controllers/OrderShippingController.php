<?php

namespace Core\Ordershipping\Http\Controllers;

use Core\Ordershipping\Application\UseCases\CreateOrderShipping;
use Core\Ordershipping\Application\DTOs\CreateOrderShippingRequest;
use Core\Ordershipping\Application\UseCases\IndexOrderShipping;
use Core\Ordershipping\Application\UseCases\ShowOrderShipping;
use Core\Ordershipping\Application\UseCases\UpdateOrderShipping;
use Core\Ordershipping\Http\Requests\CreateOrderShippingRequest as FormRequest;
use Core\Ordershipping\Http\Requests\IndexOrderShippingRequest;
use Core\Ordershipping\Http\Requests\ShowOrderShippingRequest;
use Core\Ordershipping\Http\Requests\UpdateOrderShippingRequest;

class OrderShippingController
{
    public function store(FormRequest $request, CreateOrderShipping $useCase)
    {
        $dto = CreateOrderShippingRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexOrderShippingRequest $request, IndexOrderShipping $useCase)
    {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function show(ShowOrderShippingRequest $request, ShowOrderShipping $useCase, string $id)
    {
        $request->merge(['id' => $id]);
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function update(UpdateOrderShipping $useCase,UpdateOrderShippingRequest $request,string $id) {
        $request->merge(['id' => $id]);
        $dto = CreateOrderShippingRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}
