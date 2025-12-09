<?php

namespace Core\ProductAttributes\Http\Controllers;

use Core\ProductAttributes\Application\UseCases\CreateProductAttribute;
use Core\ProductAttributes\Application\DTOs\CreateProductAttributeRequest;
use Core\ProductAttributes\Http\Requests\CreateProductAttributeRequest as FormRequest;

class CreateProductAttributeController
{
    public function __invoke(FormRequest $request, CreateProductAttribute $useCase)
    {
        $dto = CreateProductAttributeRequest::fromArray($request->validated());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}