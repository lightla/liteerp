<?php

namespace Core\User\Application\UseCases;

use App\Exceptions\BadException;
use Core\User\Application\DTOs\DeleteUserRequest;
use Core\User\Domain\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class DeleteUser
{
    public function __construct(private UserService $service) {}

    public function handle(DeleteUserRequest $dto)
    {
        DB::beginTransaction();
        $account = $this->service->findById($dto->toArray());
        if (!$account) {
            throw new BadException(__("Account is not exists on business"));
        }
        $user = Auth::guard('sanctum')->user();
        if($user->id === $account->id) {
            throw new BadException(__("You can not delete to your-self"));
        }
        Event::dispatch("erp.user.delete", [
            ...$account->toArray(),
            'role_user_id'   => $account->id,
            'user_id'   => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $account;
    }
}
