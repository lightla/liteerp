<?php

namespace Core\CategoryProduct\Http\Controllers;

use Core\CategoryProduct\Application\UseCases\CreateCategoryProduct;
use Core\CategoryProduct\Application\DTOs\CreateCategoryProductRequest;
use Core\CategoryProduct\Application\DTOs\UpdateCategoryProductRequest as DTOsUpdateCategoryProductRequest;
use Core\CategoryProduct\Application\UseCases\IndexCategoryProduct;
use Core\CategoryProduct\Application\UseCases\ShowCategoryProduct;
use Core\CategoryProduct\Application\UseCases\UpdateCategoryProduct;
use Core\CategoryProduct\Http\Requests\CreateCategoryProductRequest as FormRequest;
use Core\CategoryProduct\Http\Requests\IndexCategoryProductRequest;
use Core\CategoryProduct\Http\Requests\ShowCategoryProductRequest;
use Core\CategoryProduct\Http\Requests\UpdateCategoryProductRequest;

class CategoryProductController
{
    public function store(FormRequest $request, CreateCategoryProduct $useCase)
    {
        $dto = CreateCategoryProductRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
    public function index(IndexCategoryProductRequest $request, IndexCategoryProduct $useCase){
        return response()->json(['message' => $useCase->handle($request->all())]);
    }
    public function show(string $id, 
    ShowCategoryProductRequest $request,
    ShowCategoryProduct $useCase) {
        $request->merge(['id' => $id]);
        return response()->json(['message' => $useCase->handle($request->all())]);
    }
    public function update(UpdateCategoryProductRequest $request, 
    UpdateCategoryProduct $useCase,
    string $id) {
        $request->merge(['id' => $id]);
        $dto = DTOsUpdateCategoryProductRequest::fromArray($request->all());
        return response()->json(['message' => $useCase->handle($dto)]);
    }
}