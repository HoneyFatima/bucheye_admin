<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\Cart;
use App\Models\Category;
use App\Models\HotProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\helper\helpers;
use App\Models\Address;
use App\Models\Blogs;
use App\Models\Contact;
use App\Models\Comment;
use App\Models\Coupons;
use App\Models\CustomerAddress;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\ProductRating;
use App\Models\TopSellers;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use App\Providers\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FrontendController extends Controller
{
    public function index(Request $request){
        $hot_products=HotProduct::whereHas('product',function($q){
            $q->select('id','name','thumnails','mrp','discount_value','discount_type','restrictions','restrictions_quantity','slug')->whereHas('user');
        })->get();
        $top_sellers=TopSellers::whereHas('users',function($q){
            $q->select('id','name','profile_image');
        })->get();

        return view('frontend.index',compact('hot_products','top_sellers'));
    }

    /**
     * productCategoryList
     */
    function getproductByCategoryId(Request $request,$category_id=0,$product_name='',$sort='id'){
        if($sort=='discount'){
            $sort='discount_value';
            $order_by='desc';
        }else if($sort=="lth"){
           $sort='final_amount';
           $order_by='asc';
        }else if($sort=="htl"){
            $sort='final_amount';
            $order_by='desc';
        }else{
            $sort='id';
            $order_by='desc';
        }
        if($category_id==0){
            $category_id=$request->category_id;
        }
        $name=$request->name;
        $products =Product::where(function($q)use($name,$category_id){
           if($name){
               $q->where('name','like','%'.$name.'%');
           }
           if($category_id){
               $q->where('category_id',$category_id);
           }
       })->orderBy($sort,$order_by)->paginate(50);
      return view('frontend.product_category_list',compact('products'));
    }

    /**
     * getProductDetails
     */
    function getProductDetails(Request $request,$name,$id){
        $product =Product::with(['images'=>function ($q){

        },'ratings'=>function ($q){
            $q->select('*')->with(['user']);
        },'user_rating'=>function ($q){
            if(Auth::check()){
                $q->where('user_id',Auth::User()->id);
            }else{
                $q->where('user_id','#');
            }
            
        }])->find($id);
        
        // dd($product);
        return view('frontend.product_details',compact('product'));
    }

    /**
     * cartList
     */
    function cartList(Request $request){
        $carts=helpers::getCart();
        return view('frontend.cart_list',compact('carts'));
    }

    /**
     * cartDeleteProduct
     */
    function cartDeleteProduct(Request $request,$id){
        $session_id=Session::getId();
        Cart::where(['session_id'=>$session_id,'id'=>$id])->delete();
        return back();
    }

    /**
     * addToCart
     */
    function addToCart(Request $request,$id){
       
        $product = Product::findOrFail($id);
        if(empty($product)){
            return redirect()->back()->with('error', 'Product added to cart failed!');
        }

        $session_id=Session::getId();
        $cart= Cart::firstOrCreate(['session_id'=>$session_id,'product_id'=>$id]);
        $cart->quantity=$request->quantity ? $request->quantity : $cart->quantity + 1;
        if(Auth::check()){
            $cart->user_id=Auth::user()->id;
        }
        $cart->save();
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * removeCart
     * 
     */
    function removeCart(Request $request){
        Cart::where(['id'=>$request->id])->delete();
        $carts=helpers::getCart();
        $cart_list='';
        $total_amount=0;
        foreach($carts as $cart){
            $total_amount=$total_amount+$cart['product']['final_amount'] * $cart['quantity'];
            $cart_list.='<div class="dropdown-item" id="cart_'.$cart['id'].'">'.
                '<button class="pull-right btn btn-danger" onclick="removeCartProduct('.$cart['id'].')">'.
                    '<i class="fa fa-trash-o"></i>'.
                '</button>'.
                '<a href="#">'.
                    '<img class="img-fluid"src="'.URL::to($cart['product']['thumnails']).'" alt="Product">'.
                    '<strong>'.substr($cart['product']['name'],0,20).'</strong><span class="product-desc-price">₹ '.$cart['product']['mrp'].'</span>'.
                    '<span class="product-price text-danger">₹ '.$cart['product']['final_amount'].' * '.$cart['quantity'].'</span>'.
                '</a>'.
            '</div>'.
            '<div class="dropdown-divider"></div>'.
            '<div class="dropdown-cart-footer text-center">'.
                '<h4> <strong>Subtotal</strong>: ₹ '.$total_amount.' </h4>'.
                '<a class="btn btn-sm btn-danger" href="'.URL::to('/cart-list').'"> <i class="icofont icofont-shopping-cart"></i> VIEW  CART </a> <a href="#!" class="btn btn-sm btn-primary"> CHECKOUT </a>'.
            '</div>';
        }
        
        return response()->json(['status' =>200,'msg'=>'cart deleted successfully.','list'=>$cart_list,'cart_count'=>count($carts)]);
    }

    /**
     * showLoginForm
     */
    function showLoginForm(Request $request){
        if(Auth::check()){
            return redirect('/');
        }
        return view('frontend.user.login');
    }

    /**
     * otpSend
     */
    function otpSend(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $users=User::where(['mobile'=>$request->mobile,'role_id'=>7])->first();
        if(empty($users)){
            return response()->json(['status' => 422, 'msg' =>'your mobile number not matched our records']);
        }
        $otp=rand(1111,9999);
        $users->otp=$otp;
        // event(new ResetPassword($request->mobile,$otp));
        $users->save();
        return response()->json(['status'=>200,'msg'=>'Otp Send Successfully.','otp'=>$otp],200);
        
    }

    /**
     * otpVerication
     */
    function otpVerication(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $users=User::where(['otp'=>$request->otp,'mobile'=>$request->mobile,'role_id'=>7])->first();
        if(empty($users)){
            return response()->json(['status' => 422, 'msg' =>'invalid otp']);
        }
        $session_id=Session::getId();
        $users->otp='';
        $users->save();
        Auth::loginUsingId($users->id);
        $respo=Cart::where('session_id',$session_id)->update(['user_id'=> Auth::User()->id]);
       return response()->json(['status'=>200,'msg'=>'otp verified'],200);
    }

    /**
     * showRegisterForm 
     */
    function showRegisterForm(Request $request){
        return view('frontend.user.register');
    }

    /**
     * sellerProduct
     */
    function sellerProduct(Request $request,$id){
        echo $id;
    }

    /**
     * newRealease
     */
    function newRealease(Request $request,$sort='id'){
        if($sort=='discount'){
            $sort='discount_value';
            $order_by='desc';
        }else if($sort=="lth"){
           $sort='final_amount';
           $order_by='asc';
        }else if($sort=="htl"){
            $sort='final_amount';
            $order_by='desc';
        }else{
            $sort='id';
            $order_by='desc';
        }
        $products=Product::where('status','Active')->where('created_at', '>', (new \Carbon\Carbon)->submonths(2) )->where(function($q)use($request){
            
        })->orderBy($sort,$order_by)->paginate(100);
        return view('frontend.new_release',compact('products'));
    }

    /**
     * bestSellProduct
     */
    function bestSellProduct(Request $request){
        
        if($request->sort_by=='discount'){
            $sort='discount_value';
            $order_by='desc';
        }else if($request->sort_by=="lth"){
           $sort='final_amount';
           $order_by='asc';
        }else if($request->sort_by=="htl"){
            $sort='final_amount';
            $order_by='desc';
        }else{
            $sort='id';
            $order_by='desc';
        }
        $products=Product::wherehas('order_details')->where('status','Active')->where(function($q)use($request){
            if($request->category_id){
                $q->where('category_id',$request->category_id);
            }
            if($request->min_price && $request->max_price ){
                $q->whereBetween('mrp',[$request->min_price,$request->max_price]);
            }
            if($request->discount){
                $q->where('discount_value','>',$request->discount);
            }
            if($request->brand){
                $q->whereIn('brand',$request->brand);
            }
        })->orderBy($sort,$order_by)->paginate(100);
        return view('frontend.bestSellers',compact('products'));
    }

    /**
     * getCategoryBrand
     */
    function getCategoryBrand(Request $request){
        return  Product::select('brand')->where(function($q)use($request){
            if($request->category_id){
                $q->where('category_id',$request->category_id);
            }
        })->get()->groupBy('brand');
       
    }

    /**
     * howItWorks
     */
    function howItWorks()
    {
        return view('frontend.how_it_works');
    }

    /**
     * shippingReturn
     */
    function shippingReturn()
    {
        return view('frontend.shipping_return');
    }

    /**
     * blogs
     */
    function blogs()
    {
        $blogs = Blogs::with(['comment'=>function($q){

        }])->orderBy('id', 'asc')->paginate(5);
        return view('frontend.blogs', compact('blogs'));
    }

    /**
     * blogSingle
     */
    function blogDetails($id)
    {
        
        if(Auth::check()){
            $blog =  Blogs::with(['comment'=>function($q){

            },'user_comment'=>function($q){
                $q->where('user_id', Auth::user()->id);
            }])->find($id);
            $top_blogs =  Blogs::with(['comment'=>function($q){
    
            }])->get()->random(10);
            // dd($blog);
            return view('frontend.blog-single', compact('blog','top_blogs'));
        }
        return redirect()->route('user.login.show');
        
        
        
    }

    /**
     * blogLikeDislike
     */
    function blogLikeDislike(Request $request){
        $like=$request->like;
        $blog_id=$request->blog_id;
        $user_id=$request->user_id;
        $comments=Comment::firstOrCreate(['blog_id'=>$blog_id,'user_id'=>$user_id]);
        $comments->is_like=$like;
        if($request->comment){
            $comments->comment=$request->comment;
        }
        $comments->save();
        return response()->json(['status'=>200]);
    }

    /**
     * customerBlogRating
     */
    function customerBlogRating(Request $request){
        $comment=$request->comment;
        $blog_id=$request->blog_id;
        $rating=$request->rating;
        $comments=Comment::firstOrCreate(['blog_id'=>$blog_id,'user_id'=>Auth::User()->id]);
        $comments->comment=$comment;
        $comments->rating=$rating;
        $comments->save();
        return back()->with('message','Your comments have been updated successfully');
    }

     /**
     * customerProductRating
     */
    function customerProductRating(Request $request){
        $review=$request->review;
        $product_id=$request->product_id;
        $rating=$request->rating;
        $comments=ProductRating::firstOrCreate(['product_id'=>$product_id,'user_id'=>Auth::User()->id]);
        $comments->review=$review;
        $comments->rating=$rating;
        $comments->save();
        return back()->with('message','Your comments have been updated successfully');
    }

    /**
     * contact
     */
    function contact(Request $request)
    {
        return view('frontend.contact');
    }

    /**
     * contactSubmit
     */
    function contactSubmit(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'message' =>'required'
        ]);
        
        $contact= new Contact();
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->mobile=$request->mobile;
        $contact->message=$request->message;
        $contact->save();
        return back()->with('message','Your Request successfully submitted');
    }

    /**
     * checkout
     */
    function checkout()
    {
        $address = CustomerAddress::get();
        $checkouts=helpers::getCart();
        return view('frontend.checkout', compact('checkouts', 'address'));
    }
    
    /**
     * addAddress
     */
    function addAddress(Request $request)
    {
        $this->validate($request,[
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'pincode' => 'required|digits:6|integer',
            'state' => 'required',
            'city' =>'required'
        ]);
        
        $address= new CustomerAddress();
        $address->user_id=Auth::user()->id;
        $address->area=$request->address;
        $address->pincode=$request->pincode;
        $address->state=$request->state;
        $address->city=$request->city;
        $address->lat=$request->latitude;
        $address->lon=$request->longitude;
        $address->name=@$request->name;
        $address->mobile=@$request->mobile;
        $address->save();

        return back()->with('message','Your Address successfully submitted');
    }

    /**
     * cartDone
     */
    function cartDone()
    {
        return view('frontend.cart_done');
    }

    /**
     * checkCoupon
     */
    function checkCoupon(Request $request)
    {
        $coupons=Coupons::where(['code'=>$request->code,'status'=>'Active'])
        ->where('min_price','<',$request->total_amount)
        ->whereDate('expiry_date','>=',Date('Y-m-d'))
        ->first(); 
        if($coupons){
            if($coupons->discount_type=="fixed"){
                $discount_value=$coupons->discount_value;
            }else{
                $discount_value=($request->total_amount *  $coupons->discount_value) /100;
            }
            return response()->json(['status' =>200,'discount_value'=>$discount_value]);
        }else{
            return response()->json(['status' =>423]);
        }
    }

    /**
     * orderPlace
     */
    function orderPlace(Request $request){
        $user_id=Auth::User()->id;
        $cartList=Cart::with(['product'=>function ($q){
            $q->select('*')->with(['product_details'=>function($q){

            }]);
        }])->where('user_id',$user_id)->get();
        if(empty($cartList)){
            return ['status'=>402,'msg'=>'Cart Empty'];
        }
        $order = new Orders();
        $order->order_number="ORD".substr(time(),-3).rand(10,100);
        $order->user_id=$user_id;
        $order->payment_mode=$request->payment_method;
        $coupons_discount=0;
        
        $order->delivery_charge=@$request->delivery_charge;
        $order->address_id=$request->address_id;
        $order->order_date=Carbon::now();
        $order->payment_status="Initialize";
        $order->order_status="Pending";
        $order->save();
        $total_amount=0;
        $total_payble_amount=0;
        $discount_price=0;
        $total_product_price=0;
        foreach($cartList as $cart){
            $product_discount_price=$cart->product->mrp - $cart->product->final_amount;
            $total_amount=$total_amount + $cart->product->mrp;
            $discount_price=$discount_price + $product_discount_price;
            // Order Details Store
            $OrderDetails = new OrderDetails();
            $OrderDetails->order_id=$order->id;
            $OrderDetails->product_id=$cart->product_id;
            $OrderDetails->product_quantity=$cart->quantity;
            $OrderDetails->vendor_id=$cart->product->user_id;
            $OrderDetails->product_price=$cart->product->final_amount;
            $OrderDetails->discount_price=$product_discount_price;
            $total_product_price=$total_product_price + $cart->product->final_amount;
            $OrderDetails->save();
        }
        // echo $total_product_price;
        // die;
        if(isset($request->coupon_code) && $request->coupon_code !="" ){
            $coupons=Coupons::where(['code'=>$request->coupon_code,'status'=>'Active'])->where('min_price','<',$total_product_price)->whereDate('expiry_date','>=',Date('Y-m-d'))->first(); 
            if(!empty($coupons)){
				$order->coupon_id=$coupons->id;
                if($coupons->discount_type =="fixed"){
                    $coupons_discount=$coupons->discount_value;
                }else{
                    $coupons_discount=(($total_product_price *  $coupons->discount_value) / 100);
                }
			}
		}
        $order->total_payble_amount=$total_payble_amount=$total_amount - $discount_price - $coupons_discount;			
        $order->order_amount=$total_amount;	
        $order->discount_price=$discount_price + $coupons_discount;	
        /**
         * ONLINE
         */
        if($request->payment_method =='Online'){
            // DB::commit();
			$data=['amount'=>$total_payble_amount,'user_id'=>$user_id,'order_id'=>$order->order_id];
            return "Integrate Payment Gateway";
        }
        /** COD */
        if($request->payment_method=='COD'){
            $order->payment_status="Pending";
            $order->order_status="Ordered";
            $order->save();
        }
        /** WALLET */
        if($request->payment_method=='wallet'){
            // Create Transaction And Wallet Balance Deduct
            $transactions=Transaction::firstorCreate(['user_id'=>$user_id]);
            if($transactions->user_amount >= $total_payble_amount){
                $this->walletBalanceDeduct($user_id,$total_payble_amount,'Place Order OrderId:'.$order->id,$order->id);
                $this->transactionCreate($user_id,$total_payble_amount,'DR','Place Order OrderId:'.$order->id,$order->id);
                $order->payment_status="captured";
                $order->order_status="Ordered";
                $order->save();
            }else{
               return redirect()->back()->with('error','Insufficient wallet balance please choose another method');
            }
			
            
            
        }
       
        // Cart::where('user_id',$user_id)->delete();
        return redirect('/')->with('success','Your Order Order has been created successfully');
        
    
    }

    public function transactionCreate($user_id,$trans_amount,$trans_type,$trans_remarks,$order_id=null){
        $Transaction=Transaction::firstOrCreate(['user_id'=>$user_id]);
       if($trans_type=="DR" && $Transaction->user_amount < $trans_amount){
           $response=['status'=>'failed','msg'=>'Insufficient Balance'];
           return $response;
       }
        $Transaction->save();
        $response=$this->transactionDetailsCreate($Transaction,$trans_amount,$trans_type,$trans_remarks,$order_id);
        return $response;
    }
    public function transactionDetailsCreate($transactions,$trans_amount,$trans_type,$trans_remarks,$order_id){
        $Transaction= new TransactionDetail();
        $Transaction->trans_id=$transactions->id;
        $Transaction->trans_type=$trans_type;
        $Transaction->order_id=@$order_id;
        $Transaction->trans_date= Carbon::now();
        $Transaction->trans_amount=$trans_amount;
        if($trans_type=="CR"){
            $final_amount=$transactions->user_amount+$trans_amount;
            $Transaction->current_amount=$final_amount;
        }
        if($trans_type=="DR"){
            $final_amount=$transactions->user_amount-$trans_amount;
            $Transaction->current_amount=$final_amount;
        }
        $Transaction->trans_remarks=$trans_remarks;
        $Transaction->save();
        $transactions->user_amount=$final_amount;
        $transactions->save();
        $response=['status'=>'success','msg'=>'Transaction Success'];
        return $response;
    }
    public function walletBalanceDeduct($user_id,$trans_amount,$trans_remarks,$order_id=null){
        $Transaction=Transaction::firstOrCreate(['user_id'=>$user_id]);
        $Transaction->user_amount=$Transaction->user_amount - $trans_amount;
        $Transaction->save();
        $response=$this->transactionDetailsCreate($Transaction,$trans_amount,'CR',$trans_remarks,$order_id);
        return $response;
    }

    /**
     * orderList
     */
    function orderList(Request $request){
        $orders=Orders::with(['orderDetails'=>function($q){
            $q->select('*')->with(['product'=>function($q){
                $q->select('*')->with(['category'=>function($q){

                }]);
            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        }])->where('user_id',Auth::User()->id)->orderby('id','desc')->paginate(100);
        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * getProfile
     * 
     */
    function getProfile(Request $request){
        return view('frontend.profile');
    }

    /**
     * updateProfile
     */
    function updateProfile(Request $request){
        $user=User::where('id',Auth::User()->id)->first();
        $user->name=$request->name;
        $user->email=$request->email;
        if($request->file('profile_image')){
            $this->validate($request, [
                'profile_image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
            $image = time(). $request->profile_image->getClientOriginalName();
            $request->profile_image->move(public_path('uploads/profile/'), $image);
            $user->profile_image='uploads/profile/'.$image;
        }
        $user->save();
        return redirect()->back()->with('success','Your Profile has been updated successfully');
        
    }

    /**
     * privacy
     */
    function privacy(Request $request){
        return view('frontend.privacy');
    }

    /**
     * termsConditions
     */
    function termsConditions(Request $request){
        return view('frontend.terms_conditions');
    }
    /**
     * returnPolicy
     */
    function returnPolicy(Request $request){
        return view('frontend.return_policy');
    }

    /**
     * about
     */
    function about(Request $request){
        return view('frontend.about');
    }
}
