<?php

namespace Core\User\Application\UseCases;
use Core\User\Application\DTOs\UserRequest;
use Core\User\Domain\Entities\User;
use Core\User\Domain\Services\UserService;

class AllUser
{
    public function __construct(private UserService $service) {}

    public function handle(array $dto)
    {
        $user = $this->service->all($dto);
        return $user;
    }
}