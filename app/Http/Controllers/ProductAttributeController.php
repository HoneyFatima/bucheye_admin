<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeDetail;
use App\Models\ProductFamily;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-attribute-list|product-attribute-create|product-attribute-edit|product-attribute-delete', ['only' => ['index','store']]);
        $this->middleware('permission:product-attribute-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-attribute-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-attribute-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=ProductAttribute::orderBy('id','DESC')->paginate(20);
        return view('backend.product_attribute.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product_attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:product_attributes,deleted_at,NULL'",
            "type" => "required",
            "mendetory" => "required",
            "status" => "required"
        ]);
        $attribute=New ProductAttribute();
        $attribute->name=$request->name;
        $attribute->type=$request->type;
        $attribute->mendetory=$request->mendetory;
        $attribute->status=$request->status;
        $attribute->save();
        return redirect()->route('product-attribute.index')->with('success','Product Attribute create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attribute=ProductAttribute::find($id);
        // dd($attribute);
        return view('backend.product_attribute.edit',compact('attribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required",
            "mendetory" => "required",
            "status" => "required"
        ]);
        $attribute=ProductAttribute::find($id);
        $attribute->name=$request->name;
        $attribute->mendetory=$request->mendetory;
        $attribute->status=$request->status;
        $attribute->save();
        if(!empty($request->label)){
            foreach($request->label as  $key =>$label){
                $attribute_details = new ProductAttributeDetail();
                $attribute_details->product_attribute_id=$attribute->id;
                $attribute_details->label=$label;
                $attribute_details->value=@$request->value[$key];
                $attribute_details->order_no=@$request->order_no[$key];
                $attribute_details->save();
            }
        }
        return redirect()->route('product-attribute.index')->with('success','Product Attribute update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Attribute=ProductAttribute::find($id);
        $Attribute->delete();
        return redirect()->back()->with('success','Product Attribute delete successfully');
    }
    public function attributeValueDelete($id)
    {
        $AttributeValue=ProductAttributeDetail::find($id);
        $AttributeValue->delete();
        return redirect()->back()->with('success','Product Attribute Option delete successfully');
    }
    
}
