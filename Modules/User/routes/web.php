<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\Admin\UserController;

Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});