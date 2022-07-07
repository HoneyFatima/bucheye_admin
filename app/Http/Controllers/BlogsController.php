<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Comment;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:manage-blog-list|manage-blog-create|manage-blog-edit|manage-blog-delete', ['only' => ['index','store']]);
         $this->middleware('permission:manage-blog-create', ['only' => ['create','store']]);
         $this->middleware('permission:manage-blog-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:manage-blog-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {


        $blogs = Blogs::with(['comment'=>function($q){

        }])->orderBy('id', 'asc')->paginate(5);

        return view('backend.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blog = Blogs::get();

        return view('backend.blog.create', compact('blog'));
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
            'title' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            'short_description' => 'required',
            'long_description' => 'required',
            'status' => 'required',
            ]);
            $blog= new Blogs();
            $blog->title=$request->title;
            $blog->short_description=$request->short_description;
            $blog->long_description=$request->long_description;
            $blog->status=$request->status;

            $image = time(). $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blog/'), $image);
            $blog->image='uploads/blog/'.$image;
            $blog->save();
            return redirect()->route('blog.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blogs::find($id);

        return view('backend.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'status' => 'required',
            ]);
        $blog = Blogs::find($id);

        $blog->title=$request->title;
        $blog->short_description=$request->short_description;
        $blog->long_description=$request->long_description;
        $blog->status=$request->status;
        if($request->file('image')){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
            $image = time(). $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blog/'), $image);
            $blog->image='uploads/blog/'.$image;
        }
        $blog->save();
        return redirect()->route('blog.index')->with('success', 'Blog Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blogs::destroy($id);

        return redirect()->route('blog.index')->with('success', 'Blog deleted!');
    }
}
