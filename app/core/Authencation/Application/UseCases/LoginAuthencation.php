<?php

namespace Core\Authencation\Application\UseCases;

use App\Exceptions\UnauthorizedException;
use Core\AppToken\Application\DTOs\CreateAppTokenRequest;
use Core\AppToken\Application\UseCases\CreateAppToken;
use Core\Authencation\Application\DTOs\CreateAuthencationRequest;
use Core\Authencation\Domain\Services\AuthencationService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class LoginAuthencation
{
    public function __construct(
        private AuthencationService $service,
        private CreateAppToken $createAppToken
    ) {}

    public function handle(CreateAuthencationRequest $dto)
    {
        $account = $this->service->login($dto->toArray());
        $token = $this->createAppToken->handle(CreateAppTokenRequest::fromArray([
            'id' => $account->id,
            'data' => [
                'id' => $account->id,
                'name' => $account->name
            ],
            'exp' => 5
        ]));
        if (!$account->email_verified_at) {
            Event::dispatch('erp.notification.create', [
                'user_id' => $account->id,
                'message' => __("This is email to verify your account"),
                'title'   => __("Verify account"),
                'entity_type' => "users",
                'entity_id' => $account->id,
                'chanels' => ['mail'],
                'link'     => URL::to('/dashboard/verify-account?token=' . $token)
            ]);
            throw new UnauthorizedException(__("Your account is not verify, 
            please check inbox your mail"));
        }
        return $account;
    }
}
