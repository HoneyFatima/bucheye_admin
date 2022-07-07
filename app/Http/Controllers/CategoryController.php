<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:category-create', ['only' => ['create','store']]);
         $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:category-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Category::orderBy('id','DESC')->paginate(20);

        return view('backend.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('status','Active')->get();

        return view('backend.category.create', compact('category'));
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
            'name' => ['required', 'max:100',Rule::unique('categories')->where(function ($query) use ($request) {
                return $query->where('parent_id', $request->parent_id);
            })],
            'status' => 'required',
        ]);
        $category=new Category();
        if($request->image){
            $this->validate($request, [
                'image' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image      =     time(). $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/category/'), $image);
            $category->image='uploads/category/'.$image;
        }
        $category->name=$request->name;
        $category->status=$request->status;
        $category->parent_id=$request->parent_id ? $request->parent_id : '#';
        $category->save();
        return redirect()->route('category.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $categoriers = Category::whereNotIn('id',[$id])->where('status','Active')->get();
        return view('backend.category.edit', compact('category', 'categoriers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100', Rule::unique('categories')->where(function ($query) use ($request,$id) {
                return $query->where('id','!=',$id)->where('parent_id', $request->parent_id);
            })],
            'status' => 'required',
        ]);
        $category=Category::find($id);
        if($request->image){
            $this->validate($request, [
                'image' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image      =     time(). $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/category/'), $image);
            $category->image='uploads/category/'.$image;
        }
        $category->name=$request->name;
        $category->status=$request->status;
        $category->parent_id=$request->parent_id;
        $category->save();

        return redirect()->route('category.index')
            ->with('success', 'Cat6egory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::find($id)->delete();

        return redirect()->route('category.index')
            ->with('success', 'Category deleted successfully');
    }

    public function getChildCategory(Request $request)
    {
        $categories= Category::select('id','parent_id as parent','name as text')->where('status', 'Active')->get();
        $array=[];
        foreach($categories as $category){
            $category->state=[
                'opened'=>$category->id ==$request->category_id ? 1 :0,
                'disabled'=>0,
                'selected'=>$category->id ==$request->category_id ? 1 :0,
            ];
            array_push($array,$category);
        };
        return $array;
    }
}
