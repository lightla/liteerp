<?php

use Illuminate\Support\Facades\Route;
use Core\ProductAttributes\Http\Controllers\CreateProductAttributeController;

Route::prefix(strtolower('ProductAttributes'))->group(function () {
    Route::post('/', CreateProductAttributeController::class)->name('ProductAttribute.create');
});