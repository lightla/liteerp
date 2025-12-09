<?php

use Illuminate\Support\Facades\Route;
use Core\CustomerGroup\Http\Controllers\CustomerGroupController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/customer-groups', CustomerGroupController::class);
});