<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Modules\Dashboard\App\Http\Controllers\User\DashboardController as UserDashboardController;
use Modules\Dashboard\App\Http\Controllers\Companion\DashboardController as CompanionDashboardController;


Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});
Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])
        ->name('dashboard');
});
Route::middleware(['web', 'auth:companion'])->name('companion.')->prefix('companion')->group(function () {
    Route::get('/', [CompanionDashboardController::class, 'index'])
        ->name('dashboard');
});

