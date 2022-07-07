<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use App\Models\DeliveryBoy;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class DeliveryBoyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:deliveryBoy-list|deliveryBoy-create|deliveryBoy-edit|deliveryBoy-delete', ['only' => ['index','store']]);
         $this->middleware('permission:deliveryBoy-create', ['only' => ['create','store']]);
         $this->middleware('permission:deliveryBoy-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:deliveryBoy-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $data = User::where('role_id',6)->orderBy('id', 'desc')->paginate(20);

        return view('backend.deliveryBoy.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('backend.deliveryBoy.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
         return view('backend.deliveryBoy.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required|unique:users,mobile,'.$id,
            'password' => 'confirmed',
        ]);

        $input = $request->all();

        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }


        $user = User::find($id);
        $user->name=$request->name;
        $user->status=$request->status;
        $user->email=$request->email;
        $user->mobile=$request->mobile;
        $user->password=Hash::make($request->password);

        return redirect()->route('deliveryBoy.index')
            ->with('success', 'Delivery Boy Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryBoy  $deliveryBoy
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('deliveryBoy.index')
            ->with('success', 'Delivery Boy deleted successfully.');
    }
}
