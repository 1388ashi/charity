<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\Admin\AuthController as AdminAuthController;
use Modules\Auth\App\Http\Controllers\User\AuthController as UserAuthController;

//admin
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

Route::webSuperGroup('admin', function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::get('user/login', [UserAuthController::class, 'showLoginForm'])->name('user.login.form');
Route::post('user/login', [UserAuthController::class, 'login'])->name('user.login');

Route::webSuperGroup('user', function () {
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
});
