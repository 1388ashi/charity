<?php

use Illuminate\Support\Facades\Route;
use Modules\Companion\App\Http\Controllers\Admin\WithdrawController as AdminWithdrawController;
use Modules\Companion\App\Http\Controllers\HelpUser\HelpUserController;
use Modules\Companion\App\Http\Controllers\Companion\CompanionController as CompanionController;
use Modules\Companion\App\Http\Controllers\Companion\WithdrawController as CompanionWithdrawController;
use Modules\Companion\App\Http\Controllers\User\CompanionController as UserCompanionController;
use Modules\Companion\App\Http\Controllers\Front\CompanionController as FrontCompanionController;

Route::middleware(['web', 'auth:user'])->name('user.')->prefix('user')->group(function () {
    Route::get('management-companions', [UserCompanionController::class,'management'])->name('management.companions');
    Route::get('companions/{city}', [UserCompanionController::class,'index'])->name('companions.index');
    Route::resource('companions', UserCompanionController::class)->except(['create','index','edit','show']);
    Route::resource('withdraws', AdminWithdrawController::class);
    Route::put('withdraws/edit-status/{withdraw}',[AdminWithdrawController::class, 'editStatus'])->name('withdraws.edit-status');
});
Route::middleware(['web', 'auth:help_user'])->prefix('help-user')->group(function () {
    Route::get('/', [HelpUserController::class,'profile'])->name('help-user');
    Route::get('/list', [HelpUserController::class,'index'])->name('help-user.index');
    Route::put('/{helpUser}', [HelpUserController::class,'update'])->name('help-user.update');
    Route::get('/companions', [HelpUserController::class,'helpPage'])->name('help-user.help-page');
    Route::post('companions/pay', [HelpUserController::class,'pay'])->name('help-user.pay');
});
Route::middleware(['web', 'auth:companion'])->name('companion.')->prefix('companion')->group(function () {
    Route::post('/withdraws',[CompanionWithdrawController::class, 'store'])->name('withdraws.store');
    Route::get('/help-users', [CompanionController::class,'index'])->name('help-user.index');
    Route::get('/wallet', [CompanionWithdrawController::class,'wallet'])->name('wallet.index');
    Route::get('/withdraws',[CompanionWithdrawController::class, 'index'])->name('withdraws.index');
    Route::get('/report/transactions',[CompanionController::class, 'transactions'])->name('report.transactions');
});