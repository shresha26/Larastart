<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;
use App\Models\Transaction;
use App\Models\User;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'from_account' => 'required|integer|max:191|unique:transactions',
            'to_account' => 'required|integer|max:191|unique:transactions',
            'type' => 'required|string|max:191',
            'remarks' => 'required|string|max:191',
            'status' => 'required|string|max:191',
            'amount' => 'required|integer'
        ]);

        // transaction: sender sending money
        $transaction = Transaction::create([
            'from_account' => $request['from_account'],
            'to_account' => $request['to_account'],
            'type' => 'Dr',
            'remarks' => $request['remarks'],
            'status' => $request['status'],
            'amount' => $request['amount'],
        ]);
        //return($transaction);
        //$from_user = $transaction->senderUser->first();
       // $to_user = $transaction->receiverUser->first();

        // deduct balance from sender user
        // $from_user = select * from user where id=$request['from_account']
        // $from_id = $from_user->id;
        // $current_balance = $from_id->balance;
        // $new_balance = $from_user->balance - $request['amount']
        // $txn_user_dr =
        // update user set balance=$new_balance where form_id

        // transaction: receipent ceiving money
        // $transaction = Transaction::create([
        //     'from_account' => $request['from_account'],
        //     'to_account' => $request['to_account'],
        //     'type' => 'Cr.',
        //     'remarks' => $request['remarks'],
        //     'status' => $request['status'],
        //     'amount' => $request['amount'],
        // ]);



        // add balance to recever user
        // $
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
