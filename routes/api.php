<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('open-bank-account', [\App\Http\Controllers\BankAccountController::class, 'openBankAccount']);
Route::post('close-bank-account', [\App\Http\Controllers\BankAccountController::class, 'closeBankAccount']);
Route::get('bank-account', [\App\Http\Controllers\BankAccountController::class, 'bankAccount']);
Route::post('fill-bank-account', [\App\Http\Controllers\BankAccountController::class, 'fillBankAccount']);
Route::post('withdraw-bank-account', [\App\Http\Controllers\BankAccountController::class, 'withdrawalAccount']);
Route::get('bank-accounts', [\App\Http\Controllers\BankAccountController::class, 'bankAccounts']);

//Route::get('operations-history', [\App\Http\Controllers\OperationsController::class, 'getOperationsHistory']);
