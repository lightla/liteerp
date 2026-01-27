<?php

namespace Core\Authencation\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\Authencation\Application\UseCases\LoginBySessionToken;
use Core\Authencation\Application\UseCases\LogoutSessionToken;
use Core\Authencation\Http\Requests\SessionAuthencationRequest;
use Illuminate\Http\Request;

class SessionAuthencationController extends Controller {
    public function login(LoginBySessionToken $useCase,SessionAuthencationRequest $request){
        return $useCase->handle($request->all());
    }
    public function logout(LogoutSessionToken $useCase,Request $request){
        return $useCase->handle($request->all());
    }
}