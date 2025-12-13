<?php

namespace Core\Overview\Http\Controllers;

use Core\Overview\Application\UseCases\CreateOverview;
use Core\Overview\Application\DTOs\CreateOverviewRequest;
use Core\Overview\Http\Requests\CreateOverviewRequest as FormRequest;

class CreateOverviewController
{
    public function __invoke(FormRequest $request, CreateOverview $useCase)
    {
        $dto = CreateOverviewRequest::fromArray($request->validated());
        $entity = $useCase->handle($dto);
        return response()->json(['created' => $entity]);
    }
}