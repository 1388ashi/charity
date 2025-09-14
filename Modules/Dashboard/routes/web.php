<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Modules\Dashboard\App\Http\Controllers\User\DashboardController as UserDashboardController;


Route::webSuperGroup('admin', function () {
    //profile
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
});
Route::webSuperGroup('user', function () {
    //profile
    Route::get('/', [UserDashboardController::class, 'index'])
        ->name('dashboard');
});

