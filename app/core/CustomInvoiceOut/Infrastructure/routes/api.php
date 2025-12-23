<?php

use Illuminate\Support\Facades\Route;
use Core\CustomInvoiceOut\Http\Controllers\CustomInvoiceOutController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/custom-invoice-outs', CustomInvoiceOutController::class);
});