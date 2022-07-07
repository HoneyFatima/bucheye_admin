<?php

namespace App\Http\Controllers;

use App\Models\HotProduct;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HotProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-attribute-list|product-attribute-create|product-attribute-edit|product-attribute-delete', ['only' => ['index','store']]);
        $this->middleware('permission:product-attribute-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-attribute-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-attribute-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $products=HotProduct::whereHas('product',function($q){
            $q->select('id','name','thumnails','product_id')->whereHas('user');
        })->paginate(50);
        return view('backend.product.hot.index',compact('products'));
    }

    function create(Request $request){
        $hotproducts=HotProduct::pluck('product_id')->toArray();
        $products=Product::where('status','Active')->get();
        return view('backend.product.hot.create',compact('products','hotproducts'));
    }

    function store(Request $request){
        HotProduct::truncate();
        foreach($request->product_id as $product_id){
            $hot=new HotProduct();
            $hot->product_id=$product_id;
            $hot->save();
        }
        return redirect()->route('hot_products.index')->with('success', 'Hot Product created successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HotProduct::find($id)->delete();
        return redirect()->route('hot_products.index')->with('success', 'Hot Product deleted successfully.');
    }
}
