<?php

namespace App\Http\Controllers;

use App\Models\AreaManagement;
use App\Models\Category;
use App\Models\medicineType;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductFamily;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\UnitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class ProductController extends Controller
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

    public function getProductByCategoryId(Request $request) {
        $list=Product::where(['category_id'=>$request->category_id])->get();
        return response()->json($list);
    }

    public function index()
    {
        $data=Product::orderBy('id','DESC')->where(function($q){
            if(Auth::User()->role_id==5){
                // $q->where('user_id',Auth::User()->id);
            }
        })->paginate(50);
        return view('backend.product.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // private function getSubcategory($category_id){
        
    //     $categories=Category::where('parent_id',$category_id)->get()->toArray();
    //     if(count($categories) ==0){
    //         return[];
    //     }else{
    //         foreach($categories as $category){
    //             $category_array[$category['name']]=$category;
    //             $category_array[$category['name']]['subnode'] =$this->getSubcategory($category['id'],$category_array);
    //         }
    //     }
    //     return $category_array;
    // }

    public function create()
    {
        $categories=Category::where(['status'=>'Active'])->get()->toArray();
        $families=ProductFamily::where('status','Active')->get();
        $pincodes=AreaManagement::where('status','Active')->get();
        $unit_types=UnitType::where('status','Active')->get();
        return view('backend.product.create',compact('categories','families','pincodes','unit_types'));
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
            'name' => 'required|min:1',
            'unit_type' => 'required',
            'family_id' => 'required',
            'category_id' => 'required',
            'size' => 'required',
            'color' => 'required',
            'unit' => 'required',
            'thumnails' => 'required|mimes:jpeg,jpg,png,gif|max:500',
            'short_description' => 'required',
            'long_description' => 'required',
            'status' => 'required',
            'product_quantity' => 'required',
        ]);


        $product= New Product();
        // $product->user_id=Auth::User()->id;
        $product->name=$request->name;
        $product->family_id=$request->family_id;
        $product->slug=Str::slug($request->name);
        $product->product_quantity=$request->product_quantity;
        $product->unit_type=$request->unit_type;
        $product->family_id=$request->family_id;
        $product->category_id=$request->category_id;
        $product->unit=$request->unit;
        $product->size=$request->size;
        $product->color=$request->color;
        $product->short_description=$request->short_description;
        $product->long_description=$request->long_description;
        $product->status=$request->status;
        $product->mrp=$request->mrp;
        $product->discount_type=$request->discount_type;
        $product->discount_value=$request->discount_value;
        $product->brand=$request->brand;
        if($request->discount_type=="fixed"){
            $product->final_amount=$request->mrp - $request->discount_value;
        }else if($request->discount_type=="percentage"){
            $product->final_amount=$request->mrp -  (($request->mrp * $request->discount_value)/100);
        }else{
            $product->final_amount=$request->mrp;
        }

        /**
         * FOOD FAMILY PARAMETER
         */
        $product->product_type=$request->product_type;

        /**
         * GROCERY FAMILY
         */

        /**
         * MEDICINE FAMILY
         */
       

        $image = time(). $request->thumnails->getClientOriginalName();
        $request->thumnails->move(public_path('uploads/thumnails/'), $image);
        $product->thumnails='uploads/thumnails/'.$image;
        $product->save();
        if($request->hasfile('product_image')) {
            $request->validate([
                'product_image' => 'required',
                'product_image.*' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            foreach($request->file('product_image') as $product_images){
                $imageName = time().'.'.$product_images->getClientOriginalExtension();
                $product_images->move(public_path('/uploads/Product/'), $imageName);
                $ProductImage= new ProductImage();
                $ProductImage->product_id=$product->id;
                $ProductImage->image_path="/uploads/Product/".$imageName;
                $ProductImage->save();
            }
        }
        
        $details = $request->except('_token','name','unit_type','family_id',
        'category_id','unit','thumnails','short_description','long_description','product_image',
        'product_type','status','product_video','pincode_availability','product_quantity','restrictions_quantity','discount_type','discount_value','mrp','brand');

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
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product= Product::with(['product_details'=>function($q){
            $q->select('*')->with(['attribute'=>function($q){

            }]);
        },'images'=>function($q){

        },'videos'=>function($q){

        }])->find($id);
        $categories=Category::where(['status'=>'Active'])->get();
        $sub_categories=Category::where(['status'=>'Active','parent_id'=>$product->category_id])->get();
        $families=ProductFamily::where('status','Active')->get();
        $pincodes=AreaManagement::where('status','Active')->get();
        $unit_types=UnitType::where('status','Active')->get();
        return view('backend.product.edit',compact('categories','families','product','pincodes','unit_types','sub_categories'));
    }
    /**
     * updateProductImage
     * 
     */
    function updateProductImage(Request $request,$id){
        $ProductImage=ProductImage::find($id);
        $ProductImage->status=$request->status;
        $ProductImage->save();
        return back()->with('success', 'Product image update successfully.');
    }
    /**
     * deleteProductImage
     */
    function deleteProductImage($id){
        ProductImage::find($id)->delete();
        return back()->with('success', 'Product image deleted successfully.');
    }
    /**
     * deleteProductVideo
     */
    function deleteProductVideo($id){
        ProductVideo::find($id)->delete();
        return back()->with('success', 'Product video deleted successfully.');
    }
    /**
     * updateProductVideo
     * 
     */
    function updateProductVideo(Request $request,$id){
        $ProductVideo=ProductVideo::find($id);
        $ProductVideo->status=$request->status;
        $ProductVideo->save();
        return back()->with('success', 'Product video update successfully.');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $this->validate($request, [
            'name' => 'required|min:1',
            'unit_type' => 'required',
            'category_id' => 'required',
            'size' => 'required',
            'color' => 'required',
            'unit' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'status' => 'required',
            'product_quantity' => 'required',
        ]);


        $product= Product::find($id);
        $product->name=$request->name;
        $product->slug=Str::slug($request->name);
        $product->unit_type=$request->unit_type;
        $product->product_quantity=$request->product_quantity;
        $product->category_id=$request->category_id;
        $product->unit=$request->unit;
        $product->size=$request->size;
        $product->color=$request->color;
        $product->short_description=$request->short_description;
        $product->long_description=$request->long_description;
        $product->status=$request->status;
        $product->mrp=$request->mrp;
        $product->discount_type=$request->discount_type;
        $product->discount_value=$request->discount_value;
        $product->brand=$request->brand;
        if($request->discount_type=="fixed"){
            $product->final_amount=$request->mrp - $request->discount_value;
        }else if($request->discount_type=="percentage"){
            $product->final_amount=$request->mrp -  (($request->mrp * $request->discount_value)/100);
        }else{
            $product->final_amount=$request->mrp;
        }
        

        /**
         * FOOD FAMILY PARAMETER
         */
        $product->product_type=$request->product_type;

        /**
         * GROCERY FAMILY
         */

        /**
         * MEDICINE FAMILY
         */
        

        if($request->hasfile('thumnails')) {
            $request->validate([
                'thumnails' => 'required|mimes:jpeg,jpg,png,gif|max:500',
            ]);
            $image = time(). $request->thumnails->getClientOriginalName();
            $request->thumnails->move(public_path('uploads/thumnails/'), $image);
            $product->thumnails='uploads/thumnails/'.$image;
        }
        
        $product->save();
        if($request->hasfile('product_image')) {
            $request->validate([
                'product_image' => 'required',
                'product_image.*' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            foreach($request->file('product_image') as $product_images){
                $imageName = time().'.'.$product_images->getClientOriginalExtension();
                $product_images->move(public_path('/uploads/Product/'), $imageName);
                $ProductImage= new ProductImage();
                $ProductImage->product_id=$product->id;
                $ProductImage->image_path="/uploads/Product/".$imageName;
                $ProductImage->save();
            }
        }
        
        $details = $request->except('_token','name','unit_type','family_id',
        'category_id','unit','thumnails','short_description','long_description','product_image','product_type','status',
        'product_video','pincode_availability','_method','product_quantity','restrictions_quantity','discount_type','discount_value','mrp','brand');
        ProductDetail::where('product_id',$product->id)->delete();
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
        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully.');
    }

    public function bulkStatusUpdate(Request $request){
       Product::whereIn('id',$request->ids)->update(['status'=>$request->status]);
       return response()->json(['status'=>'success','msg'=>'status updated successfully']);
    }
}
