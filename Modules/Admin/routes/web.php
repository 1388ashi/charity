<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\App\Http\Controllers\Admin\AdminController;

Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::resource('admins', AdminController::class);
});