<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:banner-list|banner-create|banner-edit|banner-delete', ['only' => ['index','store']]);
         $this->middleware('permission:banner-create', ['only' => ['create','store']]);
         $this->middleware('permission:banner-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {

        $banners = Banner::orderBy('id', 'asc')->paginate(5);

        return view('backend.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banner = Banner::get();

        return view('backend.banner.create', compact('banner'));
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
        'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
        'link' => 'required',
        'status' => 'required',
        'application' => 'required',
        'banner_type' => 'required',
        ]);
        $banner= new Banner();
        $banner->link=$request->link;
        $banner->status=$request->status;
        $banner->application=$request->application;
        $banner->banner_type=$request->banner_type;

        $image = time(). $request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/banner/'), $image);
        $banner->image='uploads/banner/'.$image;
        $banner->save();
        return redirect()->route('banner.index')->with('success', 'Banner created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::find($id);

        return view('backend.banner.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::find($id);

        return view('backend.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'link' => 'required',
            'status' => 'required',
            'application' => 'required',
            'banner_type' => 'required',
            ]);
        $banner = Banner::find($id);

        $banner->link=$request->link;
        $banner->status=$request->status;
        $banner->application=$request->application;
        $banner->banner_type=$request->banner_type;
        if($request->file('image')){
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
            $image = time(). $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/banner/'), $image);
            $banner->image='uploads/banner/'.$image;
        }
        $banner->save();
        return redirect()->route('banner.index')->with('success', 'Banner Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::destroy($id);

        return redirect()->route('banner.index')->with('success', 'Banner deleted!');
    }
}
