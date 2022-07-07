<?php
namespace App\services;

use App\Models\Orders;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\UnitType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class productService{


    public function __construct(){
        
    }
    /**
     * store Update Product
     */
    function addupdateProduct($request,$product){
        $product->name=$request->name;
        $product->slug=Str::slug($request->name);
        $product->unique_code=$product->slug.$product->id;
        $product->product_quantity=$request->product_quantity;
        $product->unit_type=$request->unit_type;
        $product->category_id=$request->category_id;
        $product->unit=$request->unit;
        $product->short_description=$request->short_description;
        $product->long_description=$request->long_description;
        $product->status=$request->status ? $request->status : "Pending" ;
        $product->restrictions=$request->restrictions;
        $product->restrictions_quantity=$request->restrictions_quantity;
        $product->mrp=$request->mrp;
        $product->discount_type=@$request->discount;
        $product->discount_value=$request->discount_value;
        if($request->discount_type=="fixed"){
            $product->final_amount=$request->mrp - $request->discount_value;
        }else if($request->discount_type=="percentage"){
            $product->final_amount=$request->mrp -  (($request->mrp * $request->discount_value)/100);
        }else{
            $product->final_amount=$request->mrp;
        }
        $product->pincode_availability=implode(',',$request->pincode_availability);
        $product->save();
        $details = $request->except('_token','name','unit_type','family_id',
        'category_id','unit','thumnails','short_description','long_description',
        'product_image','product_type','status','product_video','pincode_availability',
        'product_quantity','restrictions','restrictions_quantity',
        'mrp','discount','discount_value','final_amount','_method','product_id');

        foreach($details as $attribute_id =>$value){
            if(is_array($details[$attribute_id])){
                $value=implode(',',$details[$attribute_id]);
            }
            $ProductDetails= new ProductDetail();
            $ProductDetails->product_attribute_id=$attribute_id;
            $ProductDetails->product_id=$product->id;
            $ProductDetails->product_attribute_value=$value;
            $ProductDetails->save();
        }
        return true;
    }

    /**
     * GET PRODUCT BY CATEGORY ID
     */
    public function getProductByCategoryId($request) {
        $list=Product::where(['category_id'=>$request->category_id])->get();
        return $list;
    }
    /**
     * deleteProductVideo
     */

    function deleteProductVideo($id){
        ProductVideo::find($id)->delete();
        return true;
    }

    /**
     * deleteProductImage
     */
    function deleteProductImage($id){
        ProductImage::find($id)->delete();
        return true;
    }

    /**
     * getVendorProduct
     */
    function getVendorProduct($request){
       $products= Product::with(['user'=>function($q){
            $q->select('id','name');
        },'family'=>function($q){
            $q->select('id','name');
        },'category'=>function($q){
            $q->select('id','name','image');
        },'sub_category'=>function($q){
            $q->select('id','name','image');
        },'sub_sub_category'=>function($q){
            $q->select('id','name','image');
        },'unit_types'=>function($q){
            $q->select('id','name');
        },'images'=>function($q){

        },'videos'=>function($q){

        }])->where('user_id',$request->user()->id)->get();
        foreach($products as $product){
            if($product['status']=="Inactive"){
                $data['Approved'][]=$product;
            }else{
                $data[$product['status']][]=$product;
            }
            
        }
        return $data;
        
    }

    /**
     * getVendorProductDetails
     */
    function getVendorProductDetails($product_id){
        return Product::with(['user'=>function($q){
            $q->select('id','name');
        },'family'=>function($q){
            $q->select('id','name');
        },'category'=>function($q){
            $q->select('id','name','image');
        },'sub_category'=>function($q){
            $q->select('id','name','image');
        },'sub_sub_category'=>function($q){
            $q->select('id','name','image');
        },'unit_types'=>function($q){
            $q->select('id','name');
        },'images'=>function($q){

        },'videos'=>function($q){

        },'product_details'=>function($q){
            $q->select('*')->with(['attribute']);
        }])->where('id',$product_id)->first();
    }

    function distance($lat1, $lon1, $lat2, $lon2) { 
        $pi80 = M_PI / 180; 
        $lat1 *= $pi80; 
        $lon1 *= $pi80; 
        $lat2 *= $pi80; 
        $lon2 *= $pi80; 
        $r = 6372.797; // radius of Earth in km 6371
        $dlat = $lat2 - $lat1; 
        $dlon = $lon2 - $lon1; 
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2); 
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
        $km = $r * $c; 
        return round($km); 
    }
    function distanceCalculate($customer_id, $order_id){
        $users=User::find($customer_id);
        $delivery_boy_lat=$users->lat;
        $delivery_boy_lon=$users->lon;
        $orders=Orders::with(['orderDetails'=>function($q){
            
        }])->find($order_id);
        $last_lat=$delivery_boy_lat;
        $last_lon=$delivery_boy_lon;
        $total_distance=0;
        $vendor_ids=array_unique(array_column($orders->orderDetails->toArray(),'vendor_id'));
        foreach($vendor_ids as $key => $vendor_id){
            $vendors=User::find($vendor_id);
            $total_distance = $total_distance + $this->distance($last_lat,$last_lon,$vendors->lat,$vendors->lon);
            $last_lat=$vendors->lat;
            $last_lon=$vendors->lon;
        }
        return ['total_distance'=>$total_distance];
 }

    
}
