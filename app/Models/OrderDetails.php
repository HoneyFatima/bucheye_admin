<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'product_quantity',
        'product_price',
        'discount_price',
        'vendor_id',
    ];
    public function product(){
        return $this->hasOne(Product ::class,'id','product_id');
    }
    public function vendor(){
        return $this->hasOne(User ::class,'id','vendor_id');
    }

}
