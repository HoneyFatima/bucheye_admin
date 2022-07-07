<?php

namespace App\Http\Controllers;

use App\Models\ProductFamily;
use Illuminate\Http\Request;

class ProductFamilyController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:product-family-list|product-family-create|product-family-edit|product-family-delete', ['only' => ['index','store']]);
         $this->middleware('permission:product-family-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-family-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-family-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProductFamily::orderBy('id','DESC')->paginate(20);

        return view('backend.product_family.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product_family.create');
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
            'name' => 'required|unique:product_families',
            'status' => 'required',
            'order_no' => 'required',
        ]);
        $family=new ProductFamily();
        $family->name=$request->name;
        $family->status=$request->status;
        $family->order_no=$request->order_no;
        $family->save();
        return redirect()->route('product-family.index')
            ->with('success', 'Product Family created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductFamily  $productFamily
     * @return \Illuminate\Http\Response
     */
    public function show(ProductFamily $productFamily)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductFamily  $productFamily
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $family = ProductFamily::find($id);
        return view('backend.product_family.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductFamily  $productFamily
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_families,name,'.$id,
            'status' => 'required',
            'order_no' => 'required',
        ]);
        $family=ProductFamily::find($id);
        $family->name=$request->name;
        $family->status=$request->status;
        $family->order_no=$request->order_no;
        $family->save();
        return redirect()->route('product-family.index')
            ->with('success', 'Product Family updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductFamily  $productFamily
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ProductFamily::find($id)->delete();

        return redirect()->route('product-family.index')
            ->with('success', 'Product Family deleted successfully.');
    }

   
}
