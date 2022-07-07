<?php

namespace App\Http\Controllers;

use App\Models\TopSellers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class TopSellersController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:top-sellers-list|top-sellers-create|top-sellers-edit|top-sellers-delete', ['only' => ['index','store']]);
        $this->middleware('permission:top-sellers-create', ['only' => ['create','store']]);
        $this->middleware('permission:top-sellers-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:top-sellers-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $top_sellers=TopSellers::whereHas('users',function($q){
            $q->select('id','name','profile_image','vendor_id');
        })->paginate(50);
        // dd($top_sellers);
        return view('backend.vendor.top.index',compact('top_sellers'));
    }

    function create(Request $request){
        $top_sellers=TopSellers::pluck('vendor_id')->toArray();
        $vendors=User::where('status','Active')->get();
        return view('backend.vendor.top.create',compact('top_sellers','vendors'));
    }

    function store(Request $request){
        TopSellers::truncate();
        foreach($request->vendor_id as $vendor_id){
            $sellers=new TopSellers();
            $sellers->vendor_id=$vendor_id;
            $sellers->save();
        }
        return redirect()->route('top-sellers.index')->with('success', 'Top Seller has been created successfully.');
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
        TopSellers::find($id)->delete();
        return redirect()->route('top-sellers.index')->with('success', 'Top Seller has been deleted successfully.');
    }
}
