<?php

namespace Core\Overview\Http\Controllers;

use Core\Overview\Application\UseCases\IndexOverview;
use Core\Overview\Application\DTOs\IndexOverviewRequest as DTOsIndexOverviewRequest;
use Core\Overview\Http\Requests\IndexOverviewRequest;

class OverviewController
{
    public function index(IndexOverviewRequest $request, IndexOverview $useCase)
    {
        $dto = DTOsIndexOverviewRequest::fromArray($request->all());
        $entity = $useCase->handle($dto);
        return response()->json(['message' => $entity]);
    }
}