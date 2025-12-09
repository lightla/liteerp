<?php

use Illuminate\Support\Facades\Route;
use Core\InventoryAdjustment\Http\Controllers\InventoryAdjustmentController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/inventory-adjustments', InventoryAdjustmentController::class);
});