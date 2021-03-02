<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopUp;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class TopUpController extends Controller
{
    //

    private function get_code() {
        return mt_rand(10000000,99999999);
    }

    private function get_balance() {
        $balances = array(10, 50, 100, 500, 1000);
        $balance = $balances[array_rand($balances)];
        return $balance;
    }

    public function store(Request $request) {
        // TODO create endpoint /api/topup/generate
        // TODO only admin can call this method




            $topupCode = $this->get_code();
            $balance = $this->get_balance();

           $topip = TopUp::create([
                'code' => $topupCode,
                'amount' => $balance,
                'status' => $request->status
            ]);
            return response()->json([
                'data'=> $topip,
                'status'=> Response::HTTP_CREATED
            ]);

    }

    public function index(TopUp $generate) {
        $data = $generate->all();
        return response()->json([
            'data'=> $data,
            'status'=> Response::HTTP_OK
        ]);

    }
    public function show(TopUp $generate){
        return response()->json([
            'data'=> $generate,
            'status'=> Response::HTTP_OK
        ]);
    }
    public function update(Request $request,Topup $generate){
        $generate->update($request->all());
        return response()->json([
            'data'=> $generate,
            'status'=> Response::HTTP_OK
        ]);
    }
    public function destroy(Request $request,Topup $generate){
        $deleted = $generate;
        $generate->delete();
        return response()->json([
            'data'=> $deleted,
            'status'=> Response::HTTP_OK
        ]);
    }
}
