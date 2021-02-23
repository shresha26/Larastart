<?php

namespace App\Http\Controllers\API;
use App\Models\Busdriverlist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
class BusdriverlistController extends Controller
{
    public function index()
    {
        return Busdriverlist::latest()->paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            //'busid' => 'required|string|max:191|unique:buses',
            //'userid' => 'required|string|max:191|unique:buses',
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:busdriverlists',
            'password' => 'required|string|min:6'
            ]);


        $bus_driver = Busdriverlist::create([
            //'busid' => $request['busid'],
            //'userid' => $request['userid'],
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        return response()->json([
            'data'=> $bus_driver,
            'status'=> Response::HTTP_CREATED
        ]);
    }

    public function update(Request $request, Busdriverlist $driver)
    {
       // $user =  User::findOrFail($id);

       $this->validate($request,[
        'name' => 'required|string|max:191',
        'email' => 'required|string|email|max:191|unique:busdriverlists,email,'.$driver->id,
        'password' => 'required|string|min:6'
        ]);
        $driver->update($request->all());
        return response()->json([
            'data'=> $driver,
            'status'=> Response::HTTP_CREATED
        ]);
    }

    public function destroy(Busdriverlist $driver)
    {
        //delete the bus

        $driver->delete();

        return ['message' => 'BusDriver Deleted'];
    }

}
