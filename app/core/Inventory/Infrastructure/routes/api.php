<?php

use Illuminate\Support\Facades\Route;
use Core\Inventory\Http\Controllers\InventoryController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/inventory', InventoryController::class);
});