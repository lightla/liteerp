<?php

namespace Core\Notifications\Http\Controllers;

use Core\Notifications\Application\UseCases\CreateNotification;
use Core\Notifications\Application\DTOs\CreateNotificationRequest;
use Core\Notifications\Http\Requests\CreateNotificationRequest as FormRequest;

class CreateNotificationController
{
    public function __invoke(FormRequest $request, CreateNotification $useCase)
    {
        $dto = CreateNotificationRequest::fromArray($request->validated());
        $entity = $useCase->handle($dto);
        return response()->json(['created' => $entity]);
    }
}