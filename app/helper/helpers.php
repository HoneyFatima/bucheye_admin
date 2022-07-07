<?php
namespace App\helper;

use App\Models\AppSetting;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\TopSellers;
use Session;
use Auth;
class helpers{


   public static function getCart(){
       $carts=Cart::with(['product'])->where(function($q){
            if(Auth::check()){
                $q->orwhere('user_id',Auth::user()->id);
            }else{
                $q->where('session_id',Session::getId());
            }
        })->get()->toArray();
    return $carts;
   }
   public static function getCartquantity($product_id){
        $carts=Cart::with(['product'])->where('product_id',$product_id)->where(function($q){
            if(Auth::check()){
                $q->orwhere('user_id',Auth::user()->id);
            }else{
                $q->where('session_id',Session::getId());
            }
        })->first();
        // dd($carts);
    return $carts;
   }

   public static function getSetting(){
        return AppSetting::where('app_type','website')->first();
   }
   public static function getCategory(){
        return  Category::where('status','active')->get();
   }
  public static function getBrand(){
    return  Product::select('brand')->get()->groupBy('brand');
  }
   public static function getProductCountByBrand($name){
        return  Product::where('brand',$name)->count();
   }

   public static function getParentCategory(){
        return  Category::where(['status'=>'active','parent_id'=>'#'])->get();
   }
   public static function getChildCategory($parent_id){
        return  Category::where(['status'=>'active','parent_id'=>$parent_id])->get();
   }

    public static function getMultipleBanner($type){
        return Banner::where(['application'=>'website','banner_type'=>$type])->get();
    }

    public static function getSingleBanner($type){
        return Banner::where(['application'=>'website','banner_type'=>$type])->first();
    }

    public static function getCommonStatus(){
        return ['Active','InActive'];
    }

    public static function getBannerType(){
        return ['Top','Bottom','Middle'];
    }
    public static function getOrderStatus(){
        return ['Booked','Delivered','Not Delivered','Picked Up','Not Delivered','Rejected','','Vendor Rejected','Delivery Accepted'];
    }
    public static function getPaymentStatus(){
        return ['Pending','Paid','Not Paid'];
    }
    public static function getPaymentMode(){
        return ['Online','Cash On Delivery'];
    }
    public static function getPaymentResponse(){
        return ['Accepted','Not Accepted'];
    }
    

    
}