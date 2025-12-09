<?php

use App\Exceptions\BadException;
use App\Http\Middleware\BusinessAdmin;
use App\Http\Middleware\BusinessToken;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsLogged;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'isLogged' => IsLogged::class,
            'business.token' => BusinessToken::class,
            'IsAdmin'   => IsAdmin::class,
            'BusinessAdmin' => BusinessAdmin::class
        ]);
        $middleware->group('business', [
            'business.token',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
