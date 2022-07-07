<?php

namespace App\Http\Controllers;

use App\Models\FamilyAttribute;
use App\Models\ProductAttribute;
use App\Models\ProductFamily;
use Illuminate\Http\Request;

class FamilyAttributeController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:family-attribute-list|family-attribute-create|family-attribute-edit|family-attribute-delete', ['only' => ['index','store']]);
         $this->middleware('permission:family-attribute-create', ['only' => ['create','store']]);
         $this->middleware('permission:family-attribute-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:family-attribute-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = FamilyAttribute::orderBy('id','DESC')->paginate(20);

        return view('backend.family_attribute.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $families=ProductFamily::where('status','Active')->get();
       $attribuites=ProductAttribute::where('status','Active')->get();

        return view('backend.family_attribute.create', compact('attribuites','families'));
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
            'product_family_id' => 'required',
            'product_attribute_id' => 'required',
            'size' => 'required',
            'color' => 'required'
        ]);
        FamilyAttribute::where(['product_family_id'=>$request->product_family_id])->delete();
        foreach($request->product_attribute_id as $attribute_id){
            $attribute= New FamilyAttribute();
            $attribute->product_family_id=$request->product_family_id;
            $attribute->product_attribute_id=$attribute_id;
            $attribute->save();
        }
        
        return redirect()->route('family-attribute.index')
        ->with('success', 'Family Attribute addedd successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FamilyAttribute  $familyAttribute
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FamilyAttribute  $familyAttribute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $families=FamilyAttribute::find($id);
        $attribuites=ProductAttribute::where('status','Active')->get();
        return view('backend.family_attribute.edit', compact('attribuites','families'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FamilyAttribute  $familyAttribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_family_id' => 'required',
            'product_attribute_id' => 'required',
            'size' => 'required',
            'color' => 'required'
        ]);
        $attribute= New FamilyAttribute();
        $attribute->product_family_id=$request->product_family_id;
        $attribute->product_attribute_id=$request->product_attribute_id;
        $attribute->save();
        
        return redirect()->route('family-attribute.index')
        ->with('success', 'Family Attribute update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FamilyAttribute  $familyAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FamilyAttribute::find($id)->delete();
        return redirect()->route('family-attribute.index')
        ->with('success', 'Family Attribute deleted successfully.');
    }
    public function getFamilyAttributeByFamilyId (Request $request){
        $family_attribute=FamilyAttribute::where('product_family_id',$request->family_id)->pluck('product_attribute_id')->toArray();
        $selected_family_attribute=FamilyAttribute::with(['attribute'=>function($q){

        }])->where('product_family_id',$request->family_id)->get();
        $attributes=ProductAttribute::with(['attributeDetails'=>function($q){

        }])->where('status','Active')->get()->toArray();
        $data=['family_attribute'=>$family_attribute,'attributes'=>$attributes,'selected_family_attribute'=>$selected_family_attribute];
        return response()->json(['status'=>200,'data'=>$data]);
    }
}
