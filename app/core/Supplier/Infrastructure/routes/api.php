<?php

use Illuminate\Support\Facades\Route;
use Core\Supplier\Http\Controllers\SupplierController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/suppliers', SupplierController::class);
});