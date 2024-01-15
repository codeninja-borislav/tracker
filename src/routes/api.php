<?php

use App\Http\Controllers\BitcoinController;
use App\Http\Controllers\SubscriptionController;
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

Route::get('/bitcoin/price/{currencyPair}', [BitcoinController::class, 'getCurrentPrice']);
Route::get('/bitcoin/historical/{currencyPair}', [BitcoinController::class, 'getHistoricalPrices']);
Route::post('/subscription/create', [SubscriptionController::class,'create']);
Route::get('/health', function() {
    return response()->json(['status' => 'online']);
});
