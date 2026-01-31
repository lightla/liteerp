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

    public function handle(array $data)
    {
        DB::beginTransaction();
        $dto = CreateUserRequest::fromArray($data);
        $checkExists = $this->service->getByEmail($dto->toArray());
        if($checkExists) {
            throw new BadException(__("user::messages.is_exists_on_business"));
        }
        $account = $this->service->findByEmailOnSystem($dto->toArray());
        if ($account) {
            Event::dispatch("erp.user.create", [
                ...$account->toArray(),
                'user_id'   => $dto->created_by,
                'role_user_id'   => $account->id,
                'business_id' => $dto->business_id,
                'role' => $dto->role
            ]);
             DB::commit();
            return $account;
        } else {
            throw new BadException(__("user::messages.not_exists"));
        }
    }
}
