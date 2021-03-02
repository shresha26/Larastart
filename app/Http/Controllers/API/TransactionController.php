<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;
use App\Models\Transaction;
use App\Models\User;
use App\Models\TopUp;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::latest()->paginate(10);
        $returns = TransactionCollection::collection($transactions);
        return response()->json([
            'data'=> $returns,
            'status'=> Response::HTTP_OK
        ]);
    }

    public function usersList(User $user){
        return response()->json([
            'data'=> $user->all(),
            'status'=> Response::HTTP_CREATED
        ]);

    }

    private function get_code() {
        return mt_rand(10000000,99999999);
    }

    private function get_balance() {
        $balances = array(10, 50, 100, 500, 1000);
        $balance = $balances[array_rand($balances)];
        return $balance;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'from_account' => 'required|integer|max:191',
            'to_account' => 'required|integer|max:191',
            'type' => 'required|string|max:191',
            'remarks' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'amount' => 'required|integer'
        ]);

        $from_user_id = $request['from_account'];
        $to_user_id = $request['to_account'];

        // TODO check if sender has enough balance

        // transaction: sender sending money
        $transaction = Transaction::create([
            'from_account' => $request['from_account'],
            'to_account' => $request['to_account'],
            'type' => 'Dr',
            'remarks' => $request['remarks'],
            'status' => $request['status'],
            'amount' => $request['amount'],
        ]);

        // Deduct balance from sender
        $from_user =  User::findOrFail($from_user_id);
        $balance = $from_user->balance;
        $balance -= $request['amount'];
        $from_user->balance = $balance;
        $from_user->save();

        // add transaction data to receiver
        $transaction1 = Transaction::create([
            'from_account' => $request['to_account'],
            'to_account' => $request['from_account'],
            'type' => 'Cr',
            'remarks' => $request['remarks'],
            'status' => $request['status'],
            'amount' => $request['amount'],
        ]);

        // Add balance to receiver
        $to_user =  User::findOrFail($to_user_id);
        $balance = $to_user->balance;
        $balance += $request['amount'];
        $to_user->balance = $balance;
        $to_user->save();

        
        return response()->json([
            'data'=> $transaction,
            'status'=> Response::HTTP_CREATED
        ]);
    }


    public function updateprofile(Request $request, Transaction $transaction)
    {
        $transaction->update($request->all());
        return response()->json([
            'data'=> $transaction,
            'status'=> Response::HTTP_CREATED
        ]);

        //return ['message' => "Success"];
    }

    // public function profile()
    // {
    //     return auth('api')->transaction();
    // }


      /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
       // $user =  User::findOrFail($id);

       $this->validate($request,[
        'from_account' => 'required|string|max:191',
        'to_account' => 'required|string|max:191',
        'type' => 'required|string|max:191',
        'remarks' => 'required|string|max:191',
        'status' => 'required|string|max:191'
        ]);
        $transaction->update($request->all());
        return response()->json([
            'data'=> $transaction,
            'status'=> Response::HTTP_CREATED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //delete the transaction

        $transaction->delete();

        return ['message' => 'transaction Deleted'];
    }
}
