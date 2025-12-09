<?php

namespace Core\User\Application\UseCases;

use App\Exceptions\BadException;
use Core\User\Application\DTOs\CreateUserRequest;
use Core\User\Domain\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

/**
 * This usecase mean is update user role on business
 * It's not update to account
 */
class UpdateUser
{
    public function __construct(private UserService $service) {}

    public function handle(CreateUserRequest $dto)
    {
        DB::beginTransaction();
        $account = $this->service->getByEmail($dto->toArray());
        if (!$account) {
            throw new BadException(__("Account is exists on business"));
        }
        $user = Auth::guard('sanctum')->user();
        if($user->id === $account->id) {
            throw new BadException(__("You can not change role your-self"));
        }
        Event::dispatch("erp.user.update", [
            ...$account->toArray(),
            'user_id'   => $dto->created_by,
            'business_id' => $dto->business_id,
            'role' => $dto->role
        ]);
        DB::commit();
        return $account;
    }
}
