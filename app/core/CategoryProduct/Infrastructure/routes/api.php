<?php

use Illuminate\Support\Facades\Route;
use Core\CategoryProduct\Http\Controllers\CategoryProductController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/category-product', CategoryProductController::class);
});