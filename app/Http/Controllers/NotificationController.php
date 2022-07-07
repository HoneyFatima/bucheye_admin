<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:notification-list|notification-create|notification-edit|notification-delete', ['only' => ['index','store']]);
         $this->middleware('permission:notification-create', ['only' => ['create','store']]);
         $this->middleware('permission:notification-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:notification-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $notifications = Notification::orderBy('id', 'asc')->paginate(5);

        return view('backend.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notification = Notification::get();

        return view('backend.notification.create', compact('notification'));
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
            'name' => 'required|unique:notifications',
            'message' => 'required',
            'status' => 'required',
        ]);

        Notification::create(['name' => $request->input('name'),
        'message' => $request->input('message'),
        'status' => $request->input('status')]);

        return redirect()->route('notification.index')->with('success', 'Notification created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification::find($id);

        return view('backend.notification.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:notifications,name,'.$id,
            'message' => 'required',
            'status' => 'required',
        ]);
        $notification = Notification::find($id);
        $input = $request->all();
        $notification->update($input);

        return redirect()->route('notification.index')->with('success', 'Notification Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notification::destroy($id);

        return redirect()->route('notification.index')->with('success', 'Notification deleted!');
    }
}
