<?php

use Illuminate\Support\Facades\Route;
use Core\Customer\Http\Controllers\CustomerController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/customers', CustomerController::class);
});