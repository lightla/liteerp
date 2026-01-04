<?php

use Core\BusinessRole\Http\Controllers\BusinessRoleController;
use Core\BusinessRole\Http\Controllers\ViewBusinessRoleController;
use Illuminate\Support\Facades\Route;
Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::get('/business-role', [BusinessRoleController::class,'index']);
    Route::get('/view/business-role',[ViewBusinessRoleController::class,'index']);
});