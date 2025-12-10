<?php

namespace Core\Business\Application\UseCases;

use Core\AppToken\Application\DTOs\CreateAppTokenRequest;
use Core\AppToken\Application\UseCases\CreateAppToken;
use Core\Authencation\Application\UseCases\ProfileAuthencation;
use Core\Business\Application\DTOs\ShowBusinessRequest;
use Core\Business\Domain\Services\BusinessService;

class ShowBusiness {
    public function __construct(private BusinessService $service, 
    private ProfileAuthencation $profile,
    private CreateAppToken $createAppToken) {}
    public function handle(ShowBusinessRequest $data) {
        $user = $this->profile->handle();
        $business = $this->service->show([
            'business_id' => $data->id,
            'user_id' => $user->id
        ]);
        $token = $this->createAppToken->handle( CreateAppTokenRequest::fromArray([
            'id' => $business['id'],
            'data' => [
                ...$business,
                'user_id' => $user->id
            ],
            'exp' => 600
        ]));
        return [
            'business' => [
                ...$business,
                'currency' => config('business.currency'),
                'currency_locale'   => config('business.currency_locale')
            ],
            'token' => $token
        ];
    }
}