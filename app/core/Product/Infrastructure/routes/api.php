<?php

use Illuminate\Support\Facades\Route;
use Core\Product\Http\Controllers\ProductController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/products', ProductController::class);
});