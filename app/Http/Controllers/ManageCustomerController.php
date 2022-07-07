<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use App\Models\ManageCustomer;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ManageCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
         $this->middleware('permission:manageCustomer-list|manageCustomer-create|manageCustomer-edit|manageCustomer-delete', ['only' => ['index','store']]);
         $this->middleware('permission:manageCustomer-create', ['only' => ['create','store']]);
         $this->middleware('permission:manageCustomer-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:manageCustomer-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::where('role_id',6)->orderBy('id', 'desc')->paginate(20);

        return view('backend.manageCustomer.index', compact('data'));
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
     * @param  \App\Models\ManageCustomer  $manageCustomer
     * @return \Illuminate\Http\Response
     */
    public function show(ManageCustomer $manageCustomer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ManageCustomer  $manageCustomer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('backend.manageCustomer.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ManageCustomer  $manageCustomer
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

        $user->update($input);

        return redirect()->route('manageCustomer.index')
            ->with('success', 'Manage Customer Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ManageCustomer  $manageCustomer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('manageCustomer.index')
            ->with('success', 'Manage Customer deleted successfully.');
    }
}
