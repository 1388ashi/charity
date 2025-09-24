<?php

use Illuminate\Support\Facades\Route;
use Modules\Companion\App\Http\Controllers\HelpUser\HelpUserController;
use Modules\Companion\App\Http\Controllers\Companion\CompanionController as CompanionController;
use Modules\Companion\App\Http\Controllers\User\CompanionController as UserCompanionController;
use Modules\Companion\App\Http\Controllers\Front\CompanionController as FrontCompanionController;

Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    Route::get('management-companions', [UserCompanionController::class,'management'])->name('management.companions');
    Route::get('companions/{city}', [UserCompanionController::class,'index'])->name('companions.index');
    Route::resource('companions', UserCompanionController::class)->except(['create','index','edit','show']);
});
Route::middleware(['web', 'auth:help_user'])->prefix('help-user')->group(function () {
    Route::get('/', [HelpUserController::class,'index'])->name('help-user');
    Route::put('/{helpUser}', [HelpUserController::class,'update'])->name('help-user.update');
    Route::get('/companions', [HelpUserController::class,'helpPage'])->name('help-user.help-page');
    Route::post('companions/pay', [HelpUserController::class,'pay'])->name('help-user.pay');
});
Route::middleware(['web', 'auth:companion'])->name('companion.')->prefix('companion')->group(function () {
    Route::get('/help-users', [CompanionController::class,'index'])->name('help-user.index');
});