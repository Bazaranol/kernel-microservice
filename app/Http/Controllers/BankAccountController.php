<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BankAccount;
use App\Models\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankAccountController extends Controller
{
    public function openBankAccount(Request $request){
        $id = BankAccount::insertGetId([
            'ownerId' => $request->ownerId,
            'balance'=>0,
            'isClosed'=>0,
        ]);

        return response()->json([
            'id' => $id,
        ]);
    }

    public function closeBankAccount(Request $request){
        $data = DB::table('accounts')->where('id', $request->id)->first();
        $set = 0;
        switch ($data->isClosed){
            case 0: $set = 1; break;
            case 1: $set = 0; break;
        }
        DB::table('accounts')->where('id', $request->id)
            ->update([
                'isClosed' => $set
            ]);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function bankAccounts(Request $request) {
        $accounts = BankAccount::where('ownerId', $request->ownerId)->get();

        return response()->json($accounts);
    }

    public function bankAccount(Request $request){
        $accountData = BankAccount::where('id', $request->id)->first();
        return response()->json([
            'id' => $accountData->id,
            'ownerId' => $accountData->ownerId,
            'balance' => $accountData->balance,
            'isClosed'=> $accountData->isClosed,
        ]);
    }

    public function fillBankAccount(Request $request){
        $validated=$request->validate([
            'money' => 'required'
        ]);
        $data = DB::table('accounts')->where('id', $request->id)->first();
        $balance = $data->balance;
        $balance += $request->money;
        DB::table('accounts')->where('id', $request->id)
            ->update([
                'balance' => $balance
            ]);

        $id = Operations::insertGetId([
            'receiverId' => $request->id,
            'senderId'=> 0,
            'amount'=> $request->money,
            'status' => 'Incoming',
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $dataWS = [
            'id' => $id,
            'receiverId' => $request->id,
            'senderId' => 0,
            'amount' => $request->money,
            'status' => 'Incoming',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $client = new \WebSocket\Client('ws://localhost:8080');
        $client ->text(json_encode($dataWS));
        $client->receive();
        $client->close();

        return response()->json([
            'status' => 'success'
        ]);
    }
    public function withdrawalAccount(Request $request){
        $validated=$request->validate([
            'money' => 'required'
        ]);

        $data = DB::table('accounts')->where('id', $request->id)->first();
        $balance = $data->balance;
        $balance -= $request->money;
        DB::table('accounts')->where('id', $request->id)
            ->update([
                'balance' => $balance
            ]);

        $id = Operations::insertGetId([
            'receiverId' => $request->id,
            'senderId'=> 0,
            'amount'=> $request->money,
            'status' => 'Withdrawal',
            'date' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $dataWS = [
            'id' => $id,
            'receiverId' => $request->id,
            'senderId' => 0,
            'amount' => $request->money,
            'status' => 'Withdrawal',
            'date' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $client = new \WebSocket\Client('ws://localhost:8080');
        $client ->text(json_encode($dataWS));
        $client->receive();
        $client->close();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
