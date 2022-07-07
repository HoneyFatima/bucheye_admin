<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['session_id','product_id','user_id','quantity'];

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
