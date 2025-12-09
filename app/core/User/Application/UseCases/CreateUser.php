<?php

namespace Core\User\Application\UseCases;

use App\Exceptions\BadException;
use Core\User\Application\DTOs\CreateUserRequest;
use Core\User\Domain\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
/**
 * This usecase mean is add user into business
 * It's not create new user
 */
class CreateUser
{
    public function __construct(private UserService $service) {}

    public function handle(CreateUserRequest $dto)
    {
        DB::beginTransaction();
        $checkExists = $this->service->getByEmail($dto->toArray());
        if($checkExists) {
            throw new BadException(__("Account is exists on business"));
        }
        $account = $this->service->findByEmailOnSystem($dto->toArray());
        if ($account) {
            Event::dispatch("erp.user.create", [
                ...$account->toArray(),
                'user_id'   => $dto->created_by,
                'business_id' => $dto->business_id,
                'role' => $dto->role
            ]);
             DB::commit();
            return $account;
        } else {
            throw new BadException(__("Account is not exists on system"));
        }
    }
}
