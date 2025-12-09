<?php

namespace Core\Product\Http\Controllers;

use Core\Product\Application\UseCases\CreateProduct;
use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Application\UseCases\IndexProduct;
use Core\Product\Application\UseCases\ShowProduct;
use Core\Product\Application\UseCases\UpdateProduct;
use Core\Product\Http\Requests\CreateProductRequest as FormRequest;
use Core\Product\Http\Requests\IndexProductRequest;
use Core\Product\Http\Requests\ShowProductRequest;
use Core\Product\Http\Requests\UpdateProductRequest;

class ProductController
{
    public function store(FormRequest $request, CreateProduct $useCase)
    {
        $dto = CreateProductRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexProductRequest $request, IndexProduct $useCase) {
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function show(ShowProductRequest $request, string $id, ShowProduct $useCase){
        $request->merge([
            'id' => $id
        ]);
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]);
    }
    public function update(string $id, 
            UpdateProductRequest $request, 
            UpdateProduct $useCase) {
        $request->merge([
            'id' => $id
        ]);
        $dto = CreateProductRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}