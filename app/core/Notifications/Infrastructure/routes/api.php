<?php

use Illuminate\Support\Facades\Route;
use Core\Notifications\Http\Controllers\CreateNotificationController;

Route::prefix(strtolower('Notifications'))->group(function () {
    Route::post('/', CreateNotificationController::class)->name('Notification.create');
});