<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// \Illuminate\Support\Facades\Route::name('payment.verify')
//     ->any('payment/{gateway}/verify', [\Modules\Invoice\App\Http\Controllers\All\PaymentController::class, 'verify']);
// \Illuminate\Support\Facades\Route::name('virtual-gateway')
//     ->get('virtual-gateway/{virtual_gateway}', [\Modules\Invoice\App\Http\Controllers\All\VirtualGatewayController::class, 'pay']);
