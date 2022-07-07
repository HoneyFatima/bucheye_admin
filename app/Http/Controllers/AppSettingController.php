<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{

    public function privacyPolicy($type){
       
        $settings=AppSetting::where('app_type',$type)->first();
        return view('privacy_policy_app',compact('settings'));
    }
    public function termCondition($type){
        $settings=AppSetting::where('app_type',$type)->first();
        return view('condition_page_app',compact('settings'));
    }
    public function about($type){
        $settings=AppSetting::where('app_type',$type)->first();
        return view('about_app',compact('settings'));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userAppSetting()
    {
        $setting=AppSetting::where('app_type','user')->first();
        return view('backend.settingApp.user',compact('setting'));

    }
    /**
     * websiteSetting
     */
    public function websiteSetting()
    {
        $setting=AppSetting::where('app_type','website')->first();
        return view('backend.settingApp.website',compact('setting'));

    }
    /**
     * websiteSettingUpdate
     */
    public function websiteSettingUpdate(Request $request)
    {
       
        $setting=AppSetting::firstOrCreate(['app_type'=>'website']);
        $setting->about=$request->about;
        $setting->privacy_policy=$request->privacy_policy;
        $setting->term_condition=$request->term_condition;
        if($request->file('logo')){
            $this->validate($request, [
                'logo' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
            $image = time(). $request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/logo/'), $image);
            $setting->logo='uploads/logo/'.$image;
        }
        $setting->save();
        return redirect()->route('manage-website-setting')->with('success', 'Setting update successfully.');

    }
    public function updateuserAppSetting(Request $request)
    {
        $setting=AppSetting::firstOrCreate(['app_type'=>'user']);
        $setting->about=$request->about;
        $setting->privacy_policy=$request->privacy_policy;
        $setting->term_condition=$request->term_condition;
        $setting->save();
        return redirect()->route('manage-user-setting')->with('success', 'Setting update successfully.');

    }

    public function vendorAppSetting()
    {
        $setting=AppSetting::where('app_type','vendor')->first();
        return view('backend.settingApp.vendor',compact('setting'));

    }
    public function updateVendorAppSetting(Request $request)
    {
        $setting=AppSetting::firstOrCreate(['app_type'=>'vendor']);
        $setting->about=$request->about;
        $setting->privacy_policy=$request->privacy_policy;
        $setting->term_condition=$request->term_condition;
        $setting->save();
        return redirect()->route('manage-vendor-setting')->with('success', 'Setting update successfully.');

    }

    public function deliveryBoyAppSetting()
    {
        $setting=AppSetting::where('app_type','deliveryBoy')->first();
        return view('backend.settingApp.deliveryBoy',compact('setting'));

    }
    public function updateDeliveryBoyAppSetting(Request $request)
    {
        $setting=AppSetting::firstOrCreate(['app_type'=>'deliveryBoy']);
        $setting->about=$request->about;
        $setting->privacy_policy=$request->privacy_policy;
        $setting->term_condition=$request->term_condition;
        $setting->save();
        return redirect()->route('manage-delivery-boy-setting')->with('success', 'Setting update successfully.');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function show(AppSetting $appSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(AppSetting $appSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AppSetting $appSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AppSetting  $appSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(AppSetting $appSetting)
    {
        //
    }
}
