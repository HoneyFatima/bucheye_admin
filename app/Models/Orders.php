<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_number',
        'address_id',
        'coupon_id',
        'offer_id',
        'order_amount',
        'delivery_charge',
        'tip_amount',
        'order_status',
        'payment_status',
        'payment_mode',
        'payment_response',
    ];
    public function orderDetails(){
        return $this->hasMany(OrderDetails ::class,'order_id','id');
    }
    public function user(){
        return $this->hasOne(User ::class,'id','user_id');
    }
    public function address(){
        return $this->hasOne(CustomerAddress ::class,'id','address_id');
    }
    public function coupon(){
        return $this->hasOne(Coupons ::class,'id','coupon_id');
    }
    public function delivery(){
        return $this->hasOne(User ::class,'id','delivery_id');
    }
    // public function offer(){
    //     return $this->hasOne(User ::class,'id','offer_id');
    // }
}
