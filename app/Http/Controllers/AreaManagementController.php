<?php

namespace App\Http\Controllers;

use App\Models\AreaManagement;
use Illuminate\Http\Request;

class AreaManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:areaManagement-list|areaManagement-create|areaManagement-edit|areaManagement-delete', ['only' => ['index','store']]);
         $this->middleware('permission:areaManagement-create', ['only' => ['create','store']]);
         $this->middleware('permission:areaManagement-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:areaManagement-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {

        $areaManagement = AreaManagement::orderBy('id', 'asc')->paginate(5);

        return view('backend.areaManagement.index', compact('areaManagement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areaManagement = AreaManagement::get();

        return view('backend.areaManagement.create', compact('areaManagement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pincode' => 'required|digits:6|integer|unique:area_management',
            'status' => 'required',
        ]);

        AreaManagement::create(['pincode' => $request->input('pincode'),
         'status' => $request->input('status')]);

        return redirect()->route('areaManagement.index')
        ->with('success', 'Area Management created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AreaManagement  $areaManagement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areaManagement = AreaManagement::find($id);

        return view('backend.areaManagement.show', compact('areaManagement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AreaManagement  $areaManagement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $areaManagement = AreaManagement::find($id);

        return view('backend.areaManagement.edit', compact('areaManagement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AreaManagement  $areaManagement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'pincode' => 'required|digits:6|integer|unique:area_management,pincode,'.$id,
            'status' => 'required',
        ]);
        $areaManagement = AreaManagement::find($id);
        $input = $request->all();
        $areaManagement->update($input);

        return redirect()->route('areaManagement.index')->with('success', 'Area Management Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AreaManagement  $areaManagement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AreaManagement::destroy($id);

        return redirect()->route('areaManagement.index')->with('success', 'Area Management deleted!');
    }
}
