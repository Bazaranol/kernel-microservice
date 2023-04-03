<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});
Route::get('/operations', function () {
    return view('operations');
});
Route::post('/operations', function (\Illuminate\Http\Request $request) {
    $data = ['receiverId' => $request->input('receiverId'),
        'senderId' => $request->input('senderId'),
        'amount' => $request->input('amount'),
        'status' => $request->input('status'),
        'date' => $request->input('date')];
    $client = new \WebSocket\Client('ws://localhost:8080');
    $client ->text(json_encode($data));
    $client->receive();
    $client->close();
    return response()->redirectTo('/operations');
})->name('operations.new');
//Route::post('fill-bank-account', [\App\Http\Controllers\BankAccountController::class, 'fillBankAccount']);
