<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\Admin\AuthController as AdminAuthController;
use Modules\Auth\App\Http\Controllers\User\AuthController as UserAuthController;
use Modules\Auth\App\Http\Controllers\Companion\AuthController as CompanionAuthController;
use Modules\Auth\App\Http\Controllers\HelpUser\AuthController as HelpUserAuthController;

//admin
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login');

Route::middleware(['web', 'auth:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
});

//user
Route::get('user/login/{mobile?}', [UserAuthController::class, 'showLoginForm'])->name('user.login.form');
Route::get('user/sms-token', [UserAuthController::class, 'showSmsPage'])->name('user.sms-page');
Route::post('user/login', [UserAuthController::class, 'login'])->name('user.login');

Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');
});

//companion
Route::get('companion/login', [CompanionAuthController::class, 'showLoginForm'])->name('companion.login.form');
Route::post('companion/login', [CompanionAuthController::class, 'login'])->name('companion.login');

Route::middleware(['web', 'auth:companion'])->name('companion.')->prefix('companion')->group(function () {
    Route::post('logout', [CompanionAuthController::class, 'logout'])->name('logout');
});

//helpUser
Route::get('help-user/login', [HelpUserAuthController::class, 'showLoginForm'])->name('help-user.login.form');
Route::post('help-user/login', [HelpUserAuthController::class, 'login'])->name('help-user.login');

Route::middleware(['web', 'auth:help_user'])->name('help-user.')->prefix('help-user')->group(function () {
    Route::post('logout', [HelpUserAuthController::class, 'logout'])->name('logout');
});