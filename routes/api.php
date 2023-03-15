<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('open-bank-account', [\App\Http\Controllers\BankAccountController::class, 'openBankAccount']);
Route::post('close-bank-account', [\App\Http\Controllers\BankAccountController::class, 'closeBankAccount']);
Route::get('details-bank-account', [\App\Http\Controllers\BankAccountController::class, 'detailsBankAccount']);
Route::post('fill-bank-account', [\App\Http\Controllers\BankAccountController::class, 'fillBankAccount']);
Route::post('withdrawal-bank-account', [\App\Http\Controllers\BankAccountController::class, 'withdrawalAccount']);


