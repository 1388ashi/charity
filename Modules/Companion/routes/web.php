<?php

use Illuminate\Support\Facades\Route;
use Modules\Companion\App\Http\Controllers\User\CompanionController as UserCompanionController;
use Modules\Companion\App\Http\Controllers\Front\CompanionController as FrontCompanionController;

Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
        Route::get('management-companions', [UserCompanionController::class,'management'])->name('management.companions');
        Route::get('companions/{city}', [UserCompanionController::class,'index'])->name('companions.index');
        Route::resource('companions', UserCompanionController::class)->except(['create','index','edit','show']);
});
Route::prefix('/')->name('front.')->group(callback: function() {
    Route::get('companions/help-page', [FrontCompanionController::class,'helpPage'])->name('companions.help-page');
    Route::post('companions/pay', [FrontCompanionController::class,'pay'])->name('companions.pay');
});