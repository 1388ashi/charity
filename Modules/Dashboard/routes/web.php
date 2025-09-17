<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Modules\Dashboard\App\Http\Controllers\User\DashboardController as UserDashboardController;


Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    //profile
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});
Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    //profile
    Route::get('/', [UserDashboardController::class, 'index'])
        ->name('dashboard');
});

