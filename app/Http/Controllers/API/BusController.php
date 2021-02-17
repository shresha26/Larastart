<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Bus $bus)
    {
        return Bus::latest()->paginate(10);
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
            'busno' => 'required|string|max:191|unique:buses',
            'buscolor' => 'required|string|max:191',
            'engineno' => 'required|string|max:191|unique:buses',
            'mfddate' => 'required|string|max:191',
            'companyname' => 'required|string|max:191|unique:buses'
            ]);
        $bus = Bus::create([
            'busno' => $request['busno'],
            'buscolor' => $request['buscolor'],
            'engineno' => $request['engineno'],
            'mfddate' => $request['mfddate'],
            'companyname' => $request['companyname'],
        ]);
        return response()->json([
            'data'=> $bus,
            'status'=> Response::HTTP_CREATED
        ]);
    }


    public function updateprofile(Request $request, Bus $bus)
    {
        $bus->update($request->all());
        return response()->json([
            'data'=> $bus,
            'status'=> Response::HTTP_CREATED
        ]);

        //return ['message' => "Success"];
    }

    // public function profile()
    // {
    //     return auth('api')->bus();
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
    public function update(Request $request, Bus $bus)
    {
       // $user =  User::findOrFail($id);

       $this->validate($request,[
        'busno' => 'required|string|max:191|unique:buses,busno,'.$bus->id,
        'buscolor' => 'required|string|max:191',
        'engineno' => 'required|string|max:191|unique:buses,engineno,'.$bus->id,
        'mfddate' => 'required|string|max:191',
        'companyname' => 'required|string|max:191|unique:buses,companyname,'.$bus->id
        ]);
        $bus->update($request->all());
        return response()->json([
            'data'=> $bus,
            'status'=> Response::HTTP_CREATED
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bus $bus)
    {
        //delete the bus

        $bus->delete();

        return ['message' => 'Bus Deleted'];
    }
}
