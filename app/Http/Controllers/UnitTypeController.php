<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Unset_;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:manage-unit-type-list|manage-unit-type-create|manage-unit-type-edit|manage-unit-type-delete', ['only' => ['index','store']]);
         $this->middleware('permission:manage-unit-type-create', ['only' => ['create','store']]);
         $this->middleware('permission:manage-unit-type-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:manage-unit-type-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $unitType = UnitType::orderBy('id', 'asc')->paginate(5);

        return view('backend.unitType.index', compact('unitType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unitType = UnitType::get();

        return view('backend.unitType.create', compact('unitType'));
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
            'name' => 'required|unique:unit_types',
            'short_name' => 'required|unique:unit_types',
            'status' => 'required',
        ]);

        UnitType::create(['name' => $request->name,'status' => $request->status,'short_name'=>$request->short_name]);

        return redirect()->route('unitType.index')->with('success', 'Unit Type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UnitType  $unitType
     * @return \Illuminate\Http\Response
     */
    public function show(UnitType $unitType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UnitType  $unitType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unitType = UnitType::find($id);

        return view('backend.unitType.edit', compact('unitType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UnitType  $unitType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:unit_types,name,'.$id,
            'status' => 'required',
        ]);
        $unitType = UnitType::find($id);
        $input = $request->all();
        $unitType->update($input);

        return redirect()->route('unitType.index')->with('success', 'Mange Unit Type Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UnitType  $unitType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UnitType::destroy($id);

        return redirect()->route('unitType.index')->with('success', 'Manage Unit Type deleted!');
    }
}
