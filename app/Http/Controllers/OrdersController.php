<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:orders-list|orders-create|orders-edit|orders-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:orders-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:orders-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:orders-delete', ['only' => ['destroy']]);
    }

    public function getOrderDetailsModelById(Request $request) {
        
        return response()->json();
    }

    public function index()
    {
        $orders=Orders::with(['orderDetails'=>function($q){
            $q->select('*')->with(['product'=>function($q){
                $q->select('*')->with(['category'=>function($q){

                }]);
            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        }])->paginate(20);
        return view('backend.orders.index', compact('orders'));
    }

    /**
     * getOrderDetails
     * 
     */
    public function getOrderDetails(Request $request){
        $order=Orders::with(['orderDetails'=>function($q){
            $q->select('*')->with(['product'=>function($q){
                $q->select('*')->with(['category'=>function($q){

                }]);
            },'vendor'=>function($q){

            }]);
        },'user'=>function($q){

        },'address'=>function($q){

        },'coupon'=>function($q){

        }
        ])->find($request->id);
        $html = view('backend.orders.order_details', compact('order'))->render();
        return $html;
        return response()->json($order);
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
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
