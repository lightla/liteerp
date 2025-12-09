<?php

namespace Core\Authencation\Application\UseCases;

use App\Exceptions\BadException;
use App\Exceptions\UnauthorizedException;
use Core\Authencation\Application\DTOs\UpdateAuthencationRequest;
use Core\Authencation\Domain\Services\AuthencationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateAuthencation
{
    public function __construct(private AuthencationService $service) {}

    public function handle(UpdateAuthencationRequest $dto)
    {
        $user = Auth::guard('sanctum')->user();
        if(!$user) {
            throw new UnauthorizedException(__("You are not logged"));
        }
        
        if($dto->password && !Hash::check($dto->password,$user->password)) {
            throw new BadException(__("Password is not correctly"));
        }
        if($dto->new_password) {
            $dto->password = $dto->new_password;
        }
        $dto->id = $user->id;
        return $this->service->update($dto->toArray());
    }
}