<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BankAccount;
use App\Models\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationsController extends Controller
{
    public function getOperationsHistory($id){
        $operations = DB::select('select * from operations where receiverId = :id', ['id' => $id]);

        return $operations;
    }


//    public function getOperationsHistory(Request $request){
//        //$operations = Operations::where('receiverId', $request->id)->get();
//        $operations = DB::select('select * from operations where receiverId = :id', ['id' => $request->id]);
//
//        $client = new \WebSocket\Client('ws://192.168.1.43:8080');
//        $client ->text(json_encode($operations));
//        $client->receive();
//        $client->close();
//        return response()->json($operations);
//    }
}
