<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\AreaManagement;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ComplainSuggestion;
use App\Models\CustomerAddress;
use App\Models\HotProduct;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\ProductFamily;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UnitType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use App\services\categoryService;
use App\services\productService;
use Illuminate\Validation\Rule;
use App\Providers\ResetPassword;
class AuthController extends Controller
{

    function __construct(categoryService $categoryService,productService $productService)
    {
       
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    
    }
    /**
     * UPLOAD FILE
     */
    private function uploadFile($vendor,$user_id,$base64,$type='.mp3'){
        if(empty($base64)){
            return "";
        }
        $folderPath = "uploads/".$vendor."/";
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $image_base64 = base64_decode($base64);
        $file = $folderPath . uniqid() .$type;
        file_put_contents($file, $image_base64);
        return $file;
    }

    /**
     * LOGIN SIGNUP
     */
    public function loginSignup(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile' => ['required',Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where(['role_id'=>4,'mobile'=>$request->mobile]);
            })],
            'fcm_token' => 'required',
            'lat' => 'required',
            'lon' => 'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $user = User:: firstOrCreate(['mobile' => $request->mobile,'role_id' =>4]);
        $user->fcm_token=$request->fcm_token;
        if ($request->otp){
            $user = User::where(['mobile'=> $request->mobile,'otp'=>$request->otp])->first();
            if(empty($user)){
                return response()->json(['status' => 422, 'message' => 'Invalid Otp']);
            }else{
                $user->tokens()->delete();
                $token = $user->createToken($request->mobile);
                $user->otp='';
                $user->save();
                return response()->json(['status' => 200,'data'=>$user, 'message' => 'Otp Verified','token'=>$token->plainTextToken]);
            }
        }else{
            $otp=rand(1000,9999);
            $user->otp=$otp;
            $user->save();
        }
        return response()->json(['status' => 200, 'message' => 'OTP sent successfully', 'otp' => $otp,]);
    }

    /**
     * getAllCategory
     */
    function getAllCategory(Request $request){
        $categories=Category::where(['status'=>'Active','parent_id'=>'#'])->get();
        return response()->json(['status' => 200, 'data' => $categories]);
    }

    /**
     * GET ADDRESS
     */
    public function getAddress(Request $request){
        $address=CustomerAddress::where('user_id',$request->user()->id)->get();
        return response()->json(['data' => $address,'status' =>200]);
    }

    /**
     * UPDATE ADDRESS
     */
    public function updateAddress(Request $request){
        $validator = validator::make($request->all(),[
            'address_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'lat' => 'required',
            'lon' => 'required',
            'area' => 'required',
            'is_default' => 'required',
            'pincode' => 'required',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
                return response()->json(['status' => 422, 'errors' => $error]);
        }

       $address =CustomerAddress::find($request->address_id);
       $address->address=$request->address;
       $address->city=$request->city;
       $address->state=$request->state;
       $address->lat=$request->lat;
       $address->lon=$request->lon;
       $address->area=$request->area;
       $address->is_default=$request->is_default;
       $address->pincode=$request->pincode;
       $address->name=@$request->name;
       $address->mobile=@$request->mobile;
       $address->save();
        return response() ->json(['data' => $address,'status' =>200]);
    }

    /**
     * Store Address
     */
    public function storeAddress(Request $request){
        $validator = validator::make($request->all(),[
            // 'address_id' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'lat' => 'required',
            'lon' => 'required',
            'area' => 'required',
            'is_default' => 'required',
            'pincode' => 'required',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
                return response()->json(['status' => 422, 'errors' => $error]);
        }

       $address =new CustomerAddress();
       $address->address=$request->address;
       $address->user_id=$request->user()->id;
       $address->city=$request->city;
       $address->state=$request->state;
       $address->lat=$request->lat;
       $address->lon=$request->lon;
       $address->area=$request->area;
       $address->is_default=$request->is_default;
       $address->pincode=$request->pincode;
       $address->name=@$request->name;
       $address->mobile=@$request->mobile;
       $address->save();
        return response() ->json(['data' => $address,'status' =>200]);
    }

    /**
     * DELETE ADDRESS
     */
    public function deleteAddress(Request $request){
        CustomerAddress::where(['user_id'=>$request->user()->id,'id'=>$request->address_id])->delete();
        return response()->json(['msg' => 'Successfully Deleted Address','status' =>200]);
    }

    /**
     * COMPLAIN SUGGESTION
     */
    public function complainSuggestion(Request $request){
        $validator = validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
                return response()->json(['status' => 422, 'errors' => $error]);
        }

        $complainSuggestion = ComplainSuggestion::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json(['msg' => 'Your Request submit successfully','status' =>200]);
    }

    /**
     * VENDOR SIGNUP
     */
    public function vendorSignUp(Request $request){
        DB::beginTransaction();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'mobile' => ['required',Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where(['role_id'=>5,'mobile'=>$request->mobile]);
            })],
            'gst' => 'required|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9]{1}Z[a-zA-Z0-9]{1}$/',
            'address' => 'required',
            'pincode' => 'required',
            'profile_image' => 'required',
            'id_proof' => 'required',
            'address_proof' => 'required',
            'cancel_cheque' => 'required',
            'lat' => 'required',
            'lon' => 'required',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }

        $user =new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->mobile=$request->mobile;
        $user->gst=$request->gst;
        $user->address=$request->address;
        $user->pincode=$request->pincode;
        $user->lat=$request->lat;
        $user->lon=$request->lon;
        $user->role_id=5;
        $user->save();
        $user->profile_image=$request->profile_image=$this->uploadFile('profile_image',$user->id,$request->profile_image,'.png');
        $user->id_proof=$request->id_proof=$this->uploadFile('id_proof',$user->id,$request->id_proof,'.png');
        $user->address_proof=$request->address_proof=$this->uploadFile('address_proof',$user->id,$request->address_proof,'.png');
        $user->cancel_cheque=$request->cancel_cheque=$this->uploadFile('cancel_cheque',$user->id,$request->cancel_cheque,'.png');
        $user->refer_code=Str::random(5).$user->id;
        if($request->refer_code){
            $referall_user=User::where('refer_code',$request->refer_code)->first();
            if(!$referall_user){
                DB::rollBack();
                return response()->json(['status' => 422, 'message' => 'Referall Code invalid']);
            }
            $user->referall_user_id=$referall_user->id;
        }
        $user->save();

        DB::commit();
        
        return response()->json(['status' => 200, 'message' => 'Vendor sign up successfully.' ]);
    }

    /**
     * LOGIN
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'fcm_token' => 'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
                return response()->json(['status' => 422, 'errors' => $error]);
        }
        if (auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user=Auth::user();
            if($user->status =='Active'){
                $token = $user->createToken('auth_token')->plainTextToken;
                $user->fcm_token=$request->fcm_token;
                $user->save();
                return response()->json(['data' => $user,'status'=>200,'token'=>$token],200);
            }else{
                $user->fcm_token=$request->fcm_token;
                $user->save();
                return response()->json(['msg' =>'Vendor not verified' ,'status'=>200],200);
            }
            
        }else{
            return response()->json(['status'=>401,'msg'=>'Credential not matched our records.'],401);
        }
    }

    /**
     * deliverylogin
     */

    public function deliverylogin(Request $request){
    	$validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
            'fcm_token' => 'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
                return response()->json(['status' => 422, 'errors' => $error]);
        }
        if (auth()->attempt(['mobile' => $request->input('mobile'), 'password' => $request->input('password'),'role_id'=>6])) {
            $user=Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $user->fcm_token=$request->fcm_token;
            $user->save();
            if($user->status =='Active'){
                
                return response()->json(['data' => $user,'status'=>200,'token'=>$token],200);
            }else{
                $user->fcm_token=$request->fcm_token;
                $user->save();
                return response()->json(['msg' =>'Delivery Boy not verified' ,'status'=>200,'token'=>$token],200);
            }
            
        }else{
            return response()->json(['status'=>401,'msg'=>'Credential not matched our records.'],401);
        }
    }

    /**
     * UPDATE PROFILE
     */
    public function UpdateProfile(Request $request){
        $users=User::find($request->user()->id);
        if($request->password && $request->password!=""){
            $users->password=Hash::make($request->password);
        }
        if($request->profile_image && !empty($request->profile_image)){
            $users->profile_image=$this->uploadFile('Profile',$request->user()->id,$request->profile_image,'.png');
        }
        $users->save();
        $response=['status'=>200,'msg'=>'Your Profile updated successfully'];
        return response()->json($response);
    }
    
    /**
     * GET PROFILE
     */
    public function profile(Request $request){
        $response=User::where('id',$request->user()->id)->first();
        return response()->json(['status'=>200,'data'=>$response]);
    }

    /**
     * DELIVERY SIGNUP
     */
    public function deliverySignup(Request $request)
    {
        DB::beginTransaction();
        $validator = Validator::make($request->all(),[
            'mobile' => ['required',Rule::unique('users')->where(function ($query) use ($request) {
                return $query->where(['role_id'=>6,'mobile'=>$request->mobile]);
            })],
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required',
            // 'mobile' => 'required|regex:/[0-9]{10}/|digits:10',
            'address' => 'required',
            'pincode' => 'required',
            'profile_image' => 'required',
            'addhar_card_front' => 'required',
            'addhar_card_back' => 'required',
            'pancard' => 'required',
            'bike_rc' => 'required',
            'bike_license' => 'required',
            'vehicle_insurance' => 'required',
            'cancel_cheque' => 'required',
            'fcm_token' => 'required',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }

        $user =new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->mobile=$request->mobile;
        $user->address=$request->address;
        $user->pincode=$request->pincode;
        $user->role_id=6;
        $user->save();
        $user->profile_image=$request->profile_image=$this->uploadFile('profile_image',$user->id,$request->profile_image,'.png');
        $user->addhar_card_front=$request->addhar_card_front=$this->uploadFile('addhar_card_front',$user->id,$request->addhar_card_front,'.png');
        $user->addhar_card_back=$request->addhar_card_back=$this->uploadFile('addhar_card_back',$user->id,$request->addhar_card_back,'.png');
        $user->pancard=$request->pancard=$this->uploadFile('pancard',$user->id,$request->pancard,'.png');
        $user->bike_rc=$request->bike_rc=$this->uploadFile('bike_rc',$user->id,$request->bike_rc,'.png');
        $user->bike_license=$request->bike_license=$this->uploadFile('bike_license',$user->id,$request->bike_license,'.png');
        $user->vehicle_insurance=$request->vehicle_insurance=$this->uploadFile('vehicle_insurance',$user->id,$request->vehicle_insurance,'.png');
        $user->cancel_cheque=$request->cancel_cheque=$this->uploadFile('cancel_cheque',$user->id,$request->cancel_cheque,'.png');
        $user->refer_code=Str::random(5).$user->id;
        if($request->refer_code){
            $referall_user=User::where('refer_code',$request->refer_code)->first();
            if(!$referall_user){
                DB::rollBack();
                return response()->json(['status' => 422, 'message' => 'Referall Code invalid']);
            }
            $user->referall_user_id=$referall_user->id;
        }
        $user->save();
        DB::commit();
        
        return response()->json(['status' => 200, 'message' => 'Delivery Boy sign up successfully.' ]);
    }
    
     /**
      * GET CATEGORY
      */
    function getCategory(Request $request){
        $datas=Category::where(['status' =>'Active','parent_id'=>'#'])->get();
        return response()->json(['status'=>200,'data'=>$datas]);
    }
    /**
     * getVendorProduct 
     */
    function getVendorProduct(Request $request){
        $datas=$this->productService->getVendorProduct($request);
        return response()->json(['status'=>200,'data'=>$datas]);
    }

    /**
     * getFamilyAttribute
     */
    function getFamilyAttribute(Request $request){
        $datas=app('App\Http\Controllers\FamilyAttributeController')->getFamilyAttributeByFamilyId($request);
        return $datas;
    }

    /**
     * getChildCategory
     */
    function getChildCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required',
            
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $datas=Category::where(['parent_id'=>$request->parent_id,'status'=>'Active'])->get();
        return response()->json(['status'=>200,'data'=>$datas]);
    }
    /**
     * storeProduct
     */
    function storeProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'family_id' => 'required',
            'unit_type' => 'required',
            'category_id' => 'required',
            'unit' => 'required',
            'thumnails' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            // 'status' => 'required',
            'pincode_availability' => 'required',
            'product_quantity' => 'required',
            'mrp'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        
        $request->pincode_availability=explode(',',$request->pincode_availability);
        $product= New Product();
        $product->user_id=Auth::User()->id;
        $product->family_id=$request->family_id;
        $product->thumnails=$this->uploadFile('thumnails','',$request->thumnails,'.jpg');
        $product->save();
        $datas=$this->productService->addupdateProduct($request,$product);
        return response()->json(['status' =>200,'msg' =>'your product creted successfully']);
    }
    /**
     * updateProduct
     */
    function updateProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            // 'family_id' => 'required',
            'unit_type' => 'required',
            'category_id' => 'required',
            'unit' => 'required',
            'thumnails' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            // 'status' => 'required',
            'pincode_availability' => 'required',
            'product_quantity' => 'required',
            'mrp'=>'required',
            'product_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        
        $request->pincode_availability=explode(',',$request->pincode_availability);
        $product= Product::find($request->product_id);
        $product->user_id=Auth::User()->id;
        $product->thumnails=$this->uploadFile('thumnails','',$request->thumnails.'.jpg');
        $product->save();
        $datas=$this->productService->addupdateProduct($request,$product);
        return response()->json(['status' =>200,'msg' =>'your product updated successfully']);
    }

    /**
     * forgotPassword
     */
    function forgotPassword(Request $request){
        $validator=Validator::make($request->all(), [
            'mobile'=>'required',
            'role_id'=>'required'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $users=User::where(['mobile'=>$request->mobile,'role_id'=>$request->role_id])->first();
        if(empty($users)){
            return response()->json(['status' =>404,'msg' =>'Your mobile number not matched your records']);
        }else{
            if($request->otp){
                if($users->otp == $request->otp){
                    $users->password=Hash::make($request->password);
                    $users->otp='';
                    $users->save();
                    return response()->json(['status' =>200,'msg' =>'Your password updated successfully']);
                }else{
                    return response()->json(['status' =>404,'msg' =>'invalid otp']);
                }
            }else{
                $otp=rand(100000,999999);
                $users->otp=$otp;
                $users->save();
                // event(new ResetPassword($users->mobile,$otp));
                return response()->json(['status' =>200,'msg' =>'OTP send your registered mobile number','otp'=>$otp]);
            }
            
        }
    }

    /**
     * getFamily
     */
    function getFamily(Request $request){
        $family=ProductFamily::where('status','Active')->get();
        return response()->json(['status' =>200,'data' =>$family]);
    }

    /**
     * deleteVendorProduct
     */
    function deleteVendorProduct(Request $request){
        $validator=Validator::make($request->all(), [
            'product_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        Product::where(['id'=>$request->product_id,'user_id'=>$request->user()->id])->delete();
        return response()->json(['status' =>200,'msg' =>'Product deleted successfully.']);
    }

    /**
     * getVendorOrders
     */
    function getVendorOrders(Request $request){
        $orders=Orders::whereHas('orderDetails',function($q)use($request){
                $q->where('vendor_id',$request->user()->id);
            })->with(['orderDetails'=>function($q)use($request){
                $q->select('*')->where('vendor_id',$request->user()->id)->with(['product'=>function($q)use($request){
                    $q->select('*')->with(['category'=>function($q)use($request){
    
                    }]);
                },'vendor'=>function($q)use($request){
                    
            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        },'delivery'=>function($q){

        }])->get();
        $data=[];
        foreach($orders as $order){
            $data[$order['orderDetails'][0]['status']][]=$order;
        }
        return response()->json(['status' =>200,'data' =>$data]);
    }

    /**
     * getNewOrderDeliveryBoy
     */
    function getNewOrderDeliveryBoy(Request $request){
        $orders=Orders::with(['orderDetails'=>function($q){
            $q->select('*')->with(['product'=>function($q){
                $q->select('*')->with(['category'=>function($q){

                }]);
            },'vendor'=>function($q){

            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        },'delivery'=>function($q){

        }])->where('order_status','Accepted')->get();
        $lists=[];
        foreach($orders as $order){
            $order->distance=$this->productService->distanceCalculate($order->user_id,$order->id);
            $lists[]=$order;  
        }
        
        return response()->json(['status' =>200,'data' =>$lists]);
    }
    /**
     * getActiveOrderDeliveryBoy
     */
    function getActiveOrderDeliveryBoy(Request $request){
        $orders=Orders::with(['orderDetails'=>function($q){
            $q->select('*')->with(['product'=>function($q){
                $q->select('*')->with(['category'=>function($q){

                }]);
            },'vendor'=>function($q){

            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        },'delivery'=>function($q){

        }])->where('delivery_id',$request->user()->id)->whereNotIn('order_status',['Ordered','Rejected','Delivered','Cancelled'])->get();
        $lists=[];
        foreach($orders as $order){
            $order->distance=$this->productService->distanceCalculate($order->user_id,$order->id);
            $lists[]=$order;  
        }
        return response()->json(['status' =>200,'data' =>$lists]);
    }
    /**
     * getDeliveredOrderDeliveryBoy
     */
    function getDeliveredOrderDeliveryBoy(Request $request){
        $orders=Orders::with(['orderDetails'=>function($q){
            $q->select('*')->with(['product'=>function($q){
                $q->select('*')->with(['category'=>function($q){

                }]);
            },'vendor'=>function($q){

            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        },'delivery'=>function($q){

        }])->where('delivery_id',$request->user()->id)->whereNotIn('order_status',['Delivered'])->get();
        $lists=[];
        foreach($orders as $order){
            $order->distance=$this->productService->distanceCalculate($order->user_id,$order->id);
            $lists[]=$order;  
        }
        return response()->json(['status' =>200,'data' =>$lists]);
    }

    /**
     * vendor Order Update
     */
    function updateVendorOrder(Request $request){
        $validator=Validator::make($request->all(), [
            'order_number'=>'required',
            'status'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $orders=Orders::where(['order_number'=>$request->order_number])->first();
        if(!empty($orders)){
            OrderDetails::where('order_id',$orders->id)->where('vendor_id',$request->user()->id)->update(['status'=>$request->status]);
            $details=OrderDetails::where('order_id',$orders->id)->get();
                if(empty($details)){
                    $orders->order_status=$request->status;
                    $orders->save();
                }
             return response()->json(['status' => 200, 'msg' => 'Order Update successfully']);
            /**
             * TODO::send customer & Delivery Boy Notification
             */
        }else{
            return response()->json(['status' => 402, 'msg' => 'Order Not found']);
        }
    }

    /**
     * updateDeliberyBoyOrder
     */

     function updateDeliveryBoyOrder(Request $request){
        $validator=Validator::make($request->all(), [
            'order_number'=>'required',
            'status'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $orders=Orders::where(['order_number'=>$request->order_number])->first();
        if(!empty($orders)){
            if($request->status=="Delivery Rejected"){
                $orders->rejected_delivery_boy_id=$orders->rejected_delivery_boy_id.','.$request->user()->id;
            }else if($request->status=="Delivery Accepted"){
                if($orders->delivery_id !="" || $orders->delivery_id !=0){
                    $orders->delivery_id=$request->user()->id;
                    $orders->order_status=$request->status;
                }else{
                    return response()->json(['status' => 402, 'msg' => 'Order Already Accepted Other Delivery Boy']);
                }
                
            }else if($request->status=="Picked Up"){
                $orders->otp=rand(100000,999999);
                $orders->order_reason_cancle=@$request->order_reason_cancle;
            }else if($request->status=="Delivered"){
                if($request->otp==$orders->otp){
                    $orders->order_status=$request->status;
                }else{
                    return response()->json(['status' => 402, 'msg' => 'Otp Not Varified']);
                }
                
            }else if($request->status=="Not Delivered"){
                $orders->order_status=$request->status;
                $orders->order_reason_cancle=@$request->order_reason_cancle;
            }else{
                $orders->order_status=$request->status;
            }
            $orders->save();
             return response()->json(['status' => 200, 'msg' => 'Order Update successfully','otp'=>$orders->otp]);
            /**
             * TODO::send customer & Delivery Boy Notification
             */
        }else{
            return response()->json(['status' => 402, 'msg' => 'Order Not found']);
        }
     }

    /**
     * getVendorTransaction
     */
    function getVendorTransaction(Request $request){
        $details=TransactionDetail::with(['order'=>function($q){
            $q->with(['orderDetails']);
        }])->whereIn('trans_id',Transaction::where('user_id',$request->user()->id)->pluck('id')->toArray())->get();
        return response()->json(['status' =>200,'data' =>$details]);
    }
    /**
     * getpincode
     */
    function getPincode(Request $request){
        $details=AreaManagement::where('status','Active')->get();
        return response()->json(['status' =>200,'data' =>$details]);
    }

    /**
     * getUnitType
     */
    function getUnitType(Request $request){
        $details=UnitType::where('status','Active')->get();
        return response()->json(['status' =>200,'data' =>$details]);
    }

    /**
     * uploadImage
     */
    function uploadImage(Request $request){
        $validator=Validator::make($request->all(), [
            'product_id'=>'required',
            'image'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        foreach(explode(',',$request->image) as $image){
            $image= new ProductImage();
            $image->product_id = $request->product_id;
            $image->status = $request->status;
            $image->image_path = $this->uploadFile('Product',$request->user()->id,$request->image,'.jpg');
            $image->save();
        }
        return response()->json(['status' =>200,'msg' =>'Product image uploaded successfully','data'=>$image]);
    }
    /**
     * image Deleted
     */
    function productImageDelete(Request $request){
        
        $validator=Validator::make($request->all(), [
            'product_image_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        
        ProductImage::find($request->product_image_id)->delete();
        
        return response()->json(['status' =>200,'msg' =>'Product image deleted successfully']);
    }

    /**
     * uploadVideo
     */
    function uploadVideo(Request $request){
        $validator=Validator::make($request->all(), [
            'product_id'=>'required',
            'video'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $video= new ProductVideo();
        $video->product_id = $request->product_id;
        $video->status = $request->status;
        $video->video_path = $this->uploadFile('Product',$request->user()->id,$request->video,'.mp4');
        $video->save();
        
        
        return response()->json(['status' =>200,'msg' =>'Product image uploaded successfully','data'=>$video]);
    }
    /**
     * video Deleted
     */
    function productVideoDelete(Request $request){
        $validator=Validator::make($request->all(), [
            'product_video_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        ProductVideo::find($request->product_video_id)->delete();
        return response()->json(['status' =>200,'msg' =>'Product video deleted successfully']);
    }

   

    /**
     * getProductDetails
     */
    function getProductDetails(Request $request){
        $validator=Validator::make($request->all(), [
            'product_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $datas=$this->productService->getVendorProductDetails($request->product_id);
        return response()->json(['status'=>200,'data'=>$datas]);
    }

    /**
     * deliveryActiveInactive
     */
    function deliveryActiveInactive(Request $request){
        $validator=Validator::make($request->all(), [
            'status'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $delivery=User::find($request->user()->id);
        $delivery->status=$request->status;
        $delivery->save();
        return response()->json(['status' =>200,'msg' =>'Status updated successfully']);
    }

    /**
     * getProductVideo
     */
    function getProductVideo(Request $request){
        $validator=Validator::make($request->all(), [
            'product_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $datas=ProductVideo::select('id','video_path','product_id')->where('product_id',$request->product_id)->get();
        return response()->json(['status'=>200,'data'=>$datas]);
    }
    /**
     * getProductImages
     */
    function getProductImages(Request $request){
        $validator=Validator::make($request->all(), [
            'product_id'=>'required',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['status' => 422, 'errors' => $error]);
        }
        $datas=ProductImage::select('id','image_path','product_id')->where('product_id',$request->product_id)->get();
        return response()->json(['status'=>200,'data'=>$datas]);
    }

    

    
}
