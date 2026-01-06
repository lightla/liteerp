<?php

use Illuminate\Support\Facades\Route;
use Core\Extension\Http\Controllers\ExtensionController;

Route::prefix('/api/business-access')->middleware(['business'])->group(function () {
    Route::resource('/extensions', ExtensionController::class);
});