<?php

namespace Core\PurchaseCancel\Http\Controllers;

use Core\PurchaseCancel\Application\UseCases\CreatePurchaseCancel;
use Core\PurchaseCancel\Application\DTOs\CreatePurchaseCancelRequest;
use Core\PurchaseCancel\Http\Requests\CreatePurchaseCancelRequest as FormRequest;

class CreatePurchaseCancelController
{
    public function __invoke(FormRequest $request, CreatePurchaseCancel $useCase)
    {
        $dto = CreatePurchaseCancelRequest::fromArray($request->validated());
        $entity = $useCase->handle($dto);
        return response()->json(['created' => $entity]);
    }
}