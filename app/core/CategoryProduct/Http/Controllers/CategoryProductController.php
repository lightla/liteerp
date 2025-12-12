<?php

namespace Core\CategoryProduct\Http\Controllers;

use Core\CategoryProduct\Application\UseCases\CreateCategoryProduct;
use Core\CategoryProduct\Application\DTOs\CreateCategoryProductRequest;
use Core\CategoryProduct\Application\DTOs\DeleteCategoryProductRequest as DTOsDeleteCategoryProductRequest;
use Core\CategoryProduct\Application\DTOs\IndexCategoryProductRequest as DTOsIndexCategoryProductRequest;
use Core\CategoryProduct\Application\UseCases\DeleteCategoryProduct;
use Core\CategoryProduct\Application\UseCases\IndexCategoryProduct;
use Core\CategoryProduct\Application\UseCases\ShowCategoryProduct;
use Core\CategoryProduct\Application\UseCases\UpdateCategoryProduct;
use Core\CategoryProduct\Http\Requests\CreateCategoryProductRequest as FormRequest;
use Core\CategoryProduct\Http\Requests\DeleteCategoryProductRequest;
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
    public function index(IndexCategoryProductRequest $request, IndexCategoryProduct $useCase)
    {
        $dto = DTOsIndexCategoryProductRequest::fromArray($request->all());
        return response()->json(['message' => $useCase->handle($dto)]);
    }
    public function show(
        string $id,
        ShowCategoryProductRequest $request,
        ShowCategoryProduct $useCase
    ) {
        $request->merge(['id' => $id]);
        return response()->json(['message' => $useCase->handle($request->all())]);
    }
    public function update(
        UpdateCategoryProductRequest $request,
        UpdateCategoryProduct $useCase,
        string $id
    ) {
        $request->merge(['id' => $id]);
        $dto = CreateCategoryProductRequest::fromArray($request->all());
        return response()->json(['message' => $useCase->handle($dto)]);
    }
    public function destroy(
        DeleteCategoryProductRequest $request,
        DeleteCategoryProduct $useCase,
        string $id
    ) {
        $request->merge(['id' => $id]);
        $dto = DTOsDeleteCategoryProductRequest::fromArray($request->all());
        return response()->json(['message' => $useCase->handle($dto)]);
    }
}
