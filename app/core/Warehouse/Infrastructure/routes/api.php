<?php

use Core\Warehouse\Http\Controllers\WarehouseAreaController;
use Illuminate\Support\Facades\Route;
use Core\Warehouse\Http\Controllers\WarehouseController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/warehouse', WarehouseController::class);
    Route::resource('/warehouse-area', WarehouseAreaController::class);
});