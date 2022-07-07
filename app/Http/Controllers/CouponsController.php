<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Category;
use App\Models\CouponCategory;
use App\Models\Coupons;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class CouponsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:coupons-list|coupons-create|coupons-edit|coupons-delete', ['only' => ['index','store']]);
         $this->middleware('permission:coupons-create', ['only' => ['create','store']]);
         $this->middleware('permission:coupons-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:coupons-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $coupons = Coupons::where(function($query){
            if(Auth::user()->role_id!=5){
                $query->where('user_id', Auth::User()->id);
            }
        })->orderBy('id', 'asc')->paginate(5);

        return view('backend.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $coupon = Coupons::get();
        $categories=Category::with(['childCategories'=>function($q){

        }])->where(['status'=>'Active'])->get()->groupBy('parent_id')->toArray();
        $products=Product::where('status','Active')->get();

        return view('backend.coupons.create', compact('coupon','categories','products'));
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
            'name' => 'required',
            'code' => 'required|unique:coupons,code',
            'min_price' => 'required|integer',
            'discount_type' => 'required|in:fixed,percentage,free',
            'max_discount' => 'required|integer',
            'status' => 'required',
            'expiry_date' => 'required',
            'description' => 'required',
            'term_condition' => 'required',
            // 'category' => 'required',
            // 'product' => 'required',
        ]);

        $coupon= new Coupons();
        $coupon->name=$request->name;
        $coupon->user_id = Auth::user()->id;
        $coupon->code=$request->code;
        $coupon->min_price=$request->min_price;
        $coupon->discount_type=$request->discount_type;
        $coupon->discount_value=$request->discount_value;
        $coupon->max_discount=$request->max_discount;
        $coupon->status=$request->status;
        $coupon->expiry_date=$request->expiry_date;
        $coupon->description=$request->description;
        $coupon->term_condition=$request->term_condition;
        $coupon->deleted_at=$request->deleted_at;
        $coupon->save();

        // foreach($request->category as $category){
        //     $couponCategory= new CouponCategory();
        //     $couponCategory->coupon_id=$coupon->id;
        //     $couponCategory->category_id=$category;
        //     $couponCategory->product_id=$request->product ? implode(',',$request->product) : '';
        //     $couponCategory->save();
        // }


        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function show(Coupons $coupons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupons::with(['coupon_categories'=>function($q)use($id){
                $q->select('*')->where('coupon_id',$id);
        }])->where('id',$id)->first();

        $categories=Category::with(['childCategories'=>function($q){

        }])->where(['status'=>'Active'])->get()->groupBy('parent_id')->toArray();
        $products=Product::where(['status'=>'Active','user_id'=>$coupon->user_id])->get();
        // dd($coupon);
        return view('backend.coupons.edit', compact('coupon','categories','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'code' => 'required|unique:coupons,code,'.$id,
            'min_price' => 'required|integer',
            'discount_type' => 'required|in:fixed,percentage,free',
            'max_discount' => 'required|integer',
            'status' => 'required',
            'expiry_date' => 'required',
            'description' => 'required',
            'term_condition' => 'required',
            'category' => 'required',
            // 'product' => 'required',

        ]);
        $coupon = Coupons::find($id);
        $coupon->name=$request->name;
        $coupon->code=$request->code;
        $coupon->min_price=$request->min_price;
        $coupon->discount_value=$request->discount_value;
        $coupon->discount_type=$request->discount_type;
        $coupon->max_discount=$request->max_discount;
        $coupon->expiry_date=$request->expiry_date;
        $coupon->description=$request->description;
        $coupon->term_condition=$request->term_condition;
        $coupon->save();

        // $couponCategory = CouponCategory::where('coupon_id',$id)->delete();
        // foreach($request->category as $category){
        //     $couponCategory= new CouponCategory();
        //     $couponCategory->coupon_id=$coupon->id;
        //     $couponCategory->category_id=$category;
        //     $couponCategory->product_id=$request->product ? implode(',',$request->product) : 0;
        //     $couponCategory->save();
        // }

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupons  $coupons
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Coupons::destroy($id);

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted!');
    }
}
