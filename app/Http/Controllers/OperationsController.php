<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BankAccount;
use App\Models\Operations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationsController extends Controller
{
    public function getOperationsHistory(Request $request){
        $operations = Operations::where('receiverId', $request->id)->get();

        return response()->json($operations);
    }
}
