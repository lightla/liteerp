<?php

namespace Core\User\Http\Controllers;

use Core\User\Application\UseCases\CreateUser;
use Core\User\Application\DTOs\CreateUserRequest;
use Core\User\Application\DTOs\DeleteUserRequest as DTOsDeleteUserRequest;
use Core\User\Application\UseCases\DeleteUser;
use Core\User\Application\UseCases\IndexUser;
use Core\User\Application\UseCases\UpdateUser;
use Core\User\Http\Requests\CreateUserRequest as CreateFormRequest;
use Core\User\Http\Requests\DeleteUserRequest;
use Core\User\Http\Requests\IndexUserRequest;
use Core\User\Http\Requests\UpdateUserRequest;

class UserController
{
    public function index(IndexUser $useCase,IndexUserRequest $request)
    {
        return response(['message' => $useCase->handle($request->all())]);
    }
    public function store(CreateFormRequest $request, CreateUser $useCase)
    {
        $form = CreateUserRequest::fromArray($request->all());
        return response(['message' => $useCase->handle($form)]);
    }
    public function update(UpdateUserRequest $request, 
        UpdateUser $useCase, string $id)
    {
        $request->merge(['id' => $id]);
        $form = CreateUserRequest::fromArray($request->all());
        return response(['message' => $useCase->handle($form)]);
    }
    public function destroy(DeleteUserRequest $request, 
        DeleteUser $useCase, string $id)
    {
        $request->merge(['id' => $id]);
        $form = DTOsDeleteUserRequest::fromArray($request->all());
        return response(['message' => $useCase->handle($form)]);
    }
}
