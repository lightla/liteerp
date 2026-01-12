<?php

use Core\Business\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

Route::prefix('/api')->middleware(['isLogged', 'app.language'])->group(function () {
    Route::get('/business', [BusinessController::class, 'index']);
    Route::get('/business/{id}', [BusinessController::class, 'show']);
    Route::middleware(['business'])->group(function () {
        Route::put('/business/{id}', [BusinessController::class, 'update']);
    });
    Route::middleware(['IsAdmin'])->group(function () {
        Route::post('/business', [BusinessController::class, 'store']);
    });
});
